<?php

namespace App\Services\Front;

use App\Models\Project;

class ProjectFrontService
{
    /**
     * تحويل المشاريع للواجهة (Frontend JSON)
     */
    public static function toFrontendJson($projects)
    {
        return $projects->map(function ($p) {
            $funded = (float) $p->investments_sum_amount ?? 0;
            $percentage = $p->funding_goal > 0 ? (int) round(($funded / $p->funding_goal) * 100) : 0;

            return [
                'id' => $p->id,
                'title' => $p->title,
                'summary' => $p->summary,
                'image' => $p->image ? asset('storage/' . $p->image) : null,
                'created_at' => $p->created_at?->toIso8601String(),
                'category' => $p->category ? ['id' => $p->category->id, 'name' => $p->category->name] : null,
                'term_months' => $p->term_months,
                'min_investment' => $p->min_investment,
                'funding_goal' => $p->funding_goal,
                'funded_amount' => $funded,
                'percentage' => $percentage,
                'interest_rate' => $p->interest_rate,
            ];
        });
    }
}
