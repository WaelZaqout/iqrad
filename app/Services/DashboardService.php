<?php

namespace App\Services;

use App\Models\Investment;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class DashboardService
{
    /**
     * جلب كل البيانات المالية والإحصائية للوحة التحكم
     */
    public function getDashboardData($lastDays = 30)
    {
        // المشاريع
        $projects = Project::with('borrower')->get();
        $investments = Investment::with('project')->get();

        // --- المشاريع حسب الحالة ---
        $statusCounts = [
            'pending'   => $projects->where('status', 'pending')->count(),
            'active'    => $projects->where('status', 'active')->count(),
            'completed' => $projects->where('status', 'completed')->count(),
            'funding'   => $projects->where('status', 'funding')->count(),
            'approved'  => $projects->where('status', 'approved')->count(),
            'defaulted' => $projects->where('status', 'defaulted')->count(),
        ];

        // --- التمويل ---
        $totalCapital = $investments->sum('amount'); // إجمالي الاستثمارات
        $receivedProfits = $investments->where('status', 'paid')->sum(function ($inv) {
            return $inv->amount * $inv->project->interest_rate / 100;
        });
        $expectedProfits = $investments->where('status', 'pending')->sum(function ($inv) {
            return $inv->amount * $inv->project->interest_rate / 100;
        });

        // --- المشاريع الأخيرة ---
        $recentProjects = Project::with('borrower')->latest()->take(5)->get();

        // --- التدفقات النقدية لآخر $lastDays يوم ---
        $cashFlow = collect();
        for ($i = $lastDays - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();

            $collections = Investment::whereDate('created_at', $date)->sum('amount') +
                Transaction::whereDate('created_at', $date)->where('type', 'credit')->sum('amount');

            $expenses = Transaction::whereDate('created_at', $date)->where('type', 'debit')->sum('amount');

            $cashFlow->push($collections - $expenses);
        }

        // --- المشاريع لكل يوم آخر $lastDays يوم ---
        $projectsDaily = collect();
        for ($i = $lastDays - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $projectsDaily->push(Project::whereDate('created_at', $date)->count());
        }

        // --- إحصاءات المستخدمين ---
        $totalInvestors = User::whereHas('roles', fn($q) => $q->where('name', 'investor'))->count();
        $totalBorrowers = User::whereHas('roles', fn($q) => $q->where('name', 'borrower'))->count();

        return [
            'statusCounts'      => $statusCounts,
            'totalCapital'      => $totalCapital,
            'receivedProfits'   => $receivedProfits,
            'expectedProfits'   => $expectedProfits,
            'recentProjects'    => $recentProjects,
            'cashFlow'          => $cashFlow,
            'projectsDaily'     => $projectsDaily,
            'totalInvestors'    => $totalInvestors,
            'totalBorrowers'    => $totalBorrowers,
        ];
    }
}
