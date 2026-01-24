<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Investment;
use App\Notifications\InvestorPayNotification;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function checkout(Investment $investment)
    {
        $investment->load('project');
        $project = $investment->project;
        $remaining = $project->funding_goal - $project->funded_amount;
        $amount = min($investment->amount, $remaining);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'sar',
                    'product_data' => [
                        'name' => 'استثمار في مشروع #' . $investment->project_id,
                    ],
                    'unit_amount' => $amount * 100, // ريال → هللة
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/stripe-success') . '?session_id={CHECKOUT_SESSION_ID}&investment=' . $investment->id,
            'cancel_url' => url('/'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $investment = Investment::with(['project', 'investor'])->findOrFail($request->investment);

        $project = $investment->project;
        $remaining = $project->funding_goal - $project->funded_amount;
        $amount = min($investment->amount, $remaining);

        // تحديث حالة الاستثمار
        $investment->update([
            'status' => 'paid',
            'paid_at' => $investment->paid_at ?? now(),
            'amount' => $amount,
        ]);

        $project->funded_amount += $amount;

        if ($project->funded_amount >= $project->funding_goal) {
            $project->status = 'completed';
        } else {
            $project->status = 'funding';
        }

        $project->save();

        $projectOwner = $project->borrower;

        // إشعار لصاحب المشروع
        $projectOwner->notify(
            new InvestorPayNotification(
                $project->title,
                'تم استثمار مبلغ جديد في مشروعك',
                $investment->amount
            )
        );

        // إشعار للمستثمر
        $investment->investor->notify(
            new InvestorPayNotification(
                $project->title,
                'تم تسجيل استثمارك بنجاح',
                $investment->amount
            )
        );

        // إضافة Toast Message للصفحة التالية
        session()->flash('toast', [
            'type' => 'success',
            'message' => "استثمر {$investment->investor->name} مبلغ {$investment->amount} ر.س في مشروع '{$project->title}'"
        ]);

        // Prepare variables expected by the success view
        $transaction = $investment;
        $transactionId = $investment->id;
        $amount = $investment->amount;
        $currency = 'ر.س';
        $projectTitle = optional($investment->project)->title ?? '-';
        $investorName = optional($investment->investor)->name ?? (Auth::check() ? Auth::user()->name : '-');
        $created_at = $investment->paid_at ?? $investment->updated_at ?? $investment->created_at;
        $paymentMethod = 'Stripe';
        $status = $investment->status ?? 'ناجحة';

        return view('front.stripe.success', compact(
            'investment',
            'transaction',
            'transactionId',
            'amount',
            'currency',
            'projectTitle',
            'investorName',
            'created_at',
            'paymentMethod',
            'status'
        ));
    }
}
