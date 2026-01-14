<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\User;
use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // عرض جميع المستثمرين
    public function index(Request $request)
    {
        $q = $request->get('q');

        // بناء الـ Query بدون تنفيذ
        $usersQuery = User::where('role', 'investor');

        // البحث
        if ($q) {
            $usersQuery->where('name', 'like', '%' . $q . '%');
        }

        // تنفيذ الاستعلام مع pagination
        $investors = $usersQuery->paginate(10);

        // استجابة Ajax
        if ($request->ajax()) {
            return response()->json([
                'rows' => view('admin.investors._rows', compact('investors'))->render(),
                'pagination' => $investors->links()->toHtml(),
            ]);
        }

        // عرض الصفحة العادية
        return view('admin.users.investors.index', compact('investors'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $investment = Investment::create([
            'project_id' => $request->project_id,
            'investor_id' => Auth::id(),
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'investment_id' => $investment->id
        ]);
    }


    /**
     * Display the specified resource.
     */

    // عرض مستثمر محدد مع تفاصيله
    public function show($id, Request $request)
    {
        $investor = User::where('role', 'investor')
            ->with([
                'investments.project',
                'transactions'
            ])
            ->findOrFail($id);
        // If an investment id is supplied, load it but DO NOT modify its status here.
        $investment = null;
        $transaction = null;
        $transactionId = null;
        $amount = null;
        $currency = 'ر.س';
        $projectTitle = null;
        $investorName = optional($investor)->name ?? '-';
        $created_at = null;
        $paymentMethod = null;
        $status = null;

        if ($request->filled('investment')) {
            $investment = Investment::with(['project', 'investor'])->find($request->investment);

            // Ensure the investment exists and belongs to the requested investor
            if (! $investment) {
                abort(404, 'Investment not found.');
            }
            if ($investment->investor_id != $investor->id) {
                abort(403, 'This investment does not belong to the specified investor.');
            }
            // Prepare variables expected by the view (read-only)
            $transaction = $investment;
            $transactionId = $investment->id;
            $amount = $investment->amount;
            $projectTitle = optional($investment->project)->title ?? '-';
            $investorName = optional($investment->investor)->name ?? (Auth::check() ? Auth::user()->name : $investor->name);
            $created_at = $investment->paid_at ?? $investment->updated_at ?? $investment->created_at;
            $paymentMethod = $investment->method ?? 'Stripe';
            $status = $investment->status ?? '-';
        }

        // إجمالي الاستثمار
        $totalInvested = $investor->investments->sum('amount');

        // أرباح مستحقة (لم يتم سحبها)
        $pendingProfits = $investor->investments->sum(function ($inv) {
            return $inv->expected_return ?? 0;
        });
        return view('admin.users.investors.show', compact(
            'investor',
            'totalInvested',
            'pendingProfits',
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $investor = User::where('type', 'investor')->findOrFail($id);
        $investor->delete();
        return redirect()->back()->with('success', 'تم حذف المستثمر بنجاح.');
    }
    public function testStripe()
    {
        Stripe::setApiKey(config('stripe.secret'));

        return "Stripe is working!";
    }
    // إجراء سريع (مثال: تفعيل/إيقاف الحساب)
    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive', // تحقق من صحة الحالة
        ]);

        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('success', 'Project status updated successfully.');
    }
}
