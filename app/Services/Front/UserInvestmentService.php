<?php

namespace App\Services\Front;

use App\Models\Investment;
use Illuminate\Support\Facades\Auth;

class UserInvestmentService
{
    /**
     * جلب جميع استثمارات المستخدم مع الحسابات الجاهزة للعرض
     *
     * @param int|null $projectId
     * @return \Illuminate\Support\Collection
     */
    public static function getInvestmentsWithStats($projectId = null)
    {
        $investments = Investment::with('project')
            ->where('investor_id', Auth::id());

        if ($projectId) {
            $investments->where('project_id', $projectId);
        }

        return $investments->get()->map(function ($investment) {
            $project = $investment->project;

            return [
                'project_id'    => $project->id,
                'title'         => $project->title,
                'amount'        => $investment->amount,
                'profit'        => round($investment->amount * $project->interest_rate / 100, 2),
                'status'        => $investment->status,
                'date'          => $investment->created_at->format('d/m/Y'),
            ];
        });
    }

    /**
     * مجموع استثمارات المستخدم الحالي في مشروع معين
     *
     * @param int|null $projectId
     * @return float
     */
    public static function getTotalInvestmentAmount($projectId = null): float
    {
        return self::getInvestmentsWithStats($projectId)->sum('amount');
    }

    /**
     * مجموع الأرباح للمستخدم في مشروع معين
     *
     * @param int|null $projectId
     * @return float
     */
    public static function getTotalProfit($projectId = null): float
    {
        return self::getInvestmentsWithStats($projectId)->sum('profit');
    }
    public static function myInvestments($projectId = null)
    {
        $query = Investment::where('investor_id', Auth::id());

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        return $query->get();
    }

    public static function investmentsWithStats()
    {
        $investments = self::myInvestments();

        return $investments->map(function ($inv) {
            return [
                'id' => $inv->id,
                'title' => $inv->project->title,
                'amount' => $inv->amount,
                'profit' => ($inv->amount * $inv->project->interest_rate) / 100,
                'status' => $inv->status,
                'date' => $inv->created_at->format('d/m/Y'),
            ];
        });
    }
}
