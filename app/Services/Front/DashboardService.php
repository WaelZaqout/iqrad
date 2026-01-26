<?php

namespace App\Services\Front;

use App\Models\Investment;
use App\Models\Project;
use App\Enums\ProjectStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public static function homepageStats(): array
    {
        $userId = Auth::id();

        $stats = [
            'activeProjects'    => Project::where('status', ProjectStatus::Active)->count(),
            'pendingProjects'   => Project::where('status', ProjectStatus::Pending)->count(),
            'completedProjects' => Project::where('status', ProjectStatus::Completed)->count(),
            'approvedProjects'  => Project::where('status', ProjectStatus::Approved)->count(),
            'fundedProjects'    => Project::where('status', ProjectStatus::Funding)->count(),
            'fundedAmount'      => Project::sum('funded_amount'),
            'fundingGoal'       => Project::sum('funding_goal'),
            'requiredFunding'   => Project::where('status', ProjectStatus::Approved)->sum('funding_goal'),
            'totalCapital'      => Investment::where('investor_id', $userId)->sum('amount'),
            'receivedProfits'   => Investment::where('investor_id', $userId)
                ->where('investments.status', 'paid') // ← أضفت اسم الجدول
                ->join('projects', 'projects.id', '=', 'investments.project_id')
                ->sum(DB::raw('(investments.amount * projects.interest_rate) / 100')),

        ];

        $stats['percentage'] = $stats['fundingGoal'] > 0
            ? round(($stats['fundedAmount'] / $stats['fundingGoal']) * 100)
            : 0;

        return $stats;
    }
}
