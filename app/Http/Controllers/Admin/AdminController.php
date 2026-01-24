<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Project;
use App\Models\Investment;
use App\Models\Transaction;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $totalInvestmentAmount = Project::where('status', ProjectStatus::Active)
            ->sum('funded_amount');
        $expectedProfits = Investment::with('project')
            ->where('status', 'pending')
            ->get() // جلب كل الاستثمارات أولاً
            ->sum(function ($inv) {
                return $inv->amount * $inv->project->interest_rate / 100;
            });

        $pendingProjects = Project::where('status', ProjectStatus::Pending)->count();
        $defaultedProjects = Project::where('status', ProjectStatus::Defaulted)->count();

        $acceptedProjects = Project::where('status', ProjectStatus::Active)->count();

        // Last 30 days projects data
        $projectsLast30 = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $count = Project::whereDate('created_at', $date)->count();
            $projectsLast30->push($count);
        }

        // Last 30 days cash flow data (collections vs expenses)
        $cashFlowLast30 = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();

            // Collections (inflows) - investments and repayments
            $collections = Investment::whereDate('created_at', $date)->sum('amount') +
                Transaction::whereDate('created_at', $date)
                ->where('type', 'credit')
                ->sum('amount');

            // Expenses (outflows) - loan disbursements and other expenses
            $expenses = Transaction::whereDate('created_at', $date)
                ->where('type', 'debit')
                ->sum('amount');

            // Net cash flow (collections - expenses)
            $netCashFlow = $collections - $expenses;
            $cashFlowLast30->push($netCashFlow);
        }

        // Additional stats
        $totalInvestors = User::whereHas('roles', function ($query) {
            $query->where('name', 'investor');
        })->count();
        $totalBorrowers = User::whereHas('roles', function ($query) {
            $query->where('name', 'borrower');
        })->count();

        // Recent projects
        $recentProjects = Project::with('borrower') // هنا نستدعي المقترض
            ->latest()
            ->take(5)
            ->get();


        return view('admin.index', compact(
            'user',
            'totalInvestmentAmount',
            'pendingProjects',
            'defaultedProjects',
            'expectedProfits',
            'acceptedProjects',
            'projectsLast30',
            'cashFlowLast30',
            'totalInvestors',
            'totalBorrowers',
            'recentProjects'
        ));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
