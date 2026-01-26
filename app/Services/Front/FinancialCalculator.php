<?php

namespace App\Services\Front;

class FinancialCalculator
{
    /**
     * حساب ربح استثمار واحد
     */
    public static function investmentProfit(float $amount, float $interestRate): float
    {
        return round(($amount * $interestRate) / 100, 2);
    }

    /**
     * حساب إجمالي الأرباح لمجموعة استثمارات
     */
    public static function totalProfit(iterable $investments): float
    {
        return collect($investments)->sum(function ($investment) {
            return self::investmentProfit(
                $investment->amount,
                $investment->project->interest_rate
            );
        });
    }

    /**
     * حساب نسبة التمويل
     */
    public static function fundingPercentage(float $funded, float $goal): int
    {
        if ($goal <= 0) {
            return 0;
        }

        return min((int) round(($funded / $goal) * 100), 100);
    }

    /**
     * توزيع التمويل على البنود (Financial Plan)
     */
    public static function financialDistribution(float $fundingGoal): array
    {
        return [
            'تطوير المنصة التقنية' => $fundingGoal * 0.4,
            'المحتوى التعليمي'    => $fundingGoal * 0.25,
            'التسويق والترويج'    => $fundingGoal * 0.15,
            'التدريب والدعم الفني' => $fundingGoal * 0.1,
            'التكاليف الإدارية'   => $fundingGoal * 0.1,
        ];
    }

    /**
     * خطة مالية للمشروع (سنوي)
     */
    public static function financialPlan(float $fundingGoal): array
    {
        $years = ['الأولى', 'الثانية', 'الثالثة'];
        $plan = [];
        $initialRevenue = $fundingGoal * 0.3;
        $cost = $fundingGoal * 0.25;

        foreach ($years as $i => $year) {
            $revenue = $initialRevenue * pow(2, $i);
            $plan[] = [
                'year' => $year,
                'revenue' => $revenue,
                'cost' => $cost,
                'profit' => $revenue - $cost,
                'profit_percent' => round((($revenue - $cost) / $cost) * 100, 1),
            ];
        }

        return $plan;
    }
}
