<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Traits\HasLocale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasLocale;

    /* =========================
     |  Configuration
     ========================= */

    protected $fillable = [
        'borrower_id',
        'category_id',
        'title_en',
        'title_ar',
        'summary_en',
        'summary_ar',
        'description_en',
        'description_ar',
        'funding_goal',
        'funded_amount',
        'interest_rate',
        'min_investment',
        'term_months',
        'status',
        'slug',
        'image',
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
        'reviewed_at' => 'datetime',
        'pre_approved_at' => 'datetime',
        'open_for_investment_at' => 'datetime',
        'funded_at' => 'datetime',
        'repayment_started_at' => 'datetime',
    ];

    /* =========================
     |  Scopes
     ========================= */

    public function scopeVisibleTo($query, $user)
    {
        if (!$user) {
            return $query;
        }

        if ($user->hasRole('borrower')) {
            return $query->where('borrower_id', $user->id);
        }

        return $query;
    }

    public function scopeSearch($query, ?string $term)
    {
        if (!$term) {
            return $query;
        }

        $locale = app()->getLocale();

        return $query->where(function ($q) use ($term, $locale) {
            $q->where("title_{$locale}", 'like', "%{$term}%")
                ->orWhereHas(
                    'borrower',
                    fn($b) =>
                    $b->where('name', 'like', "%{$term}%")
                )
                ->orWhereHas(
                    'category',
                    fn($c) =>
                    $c->where("name_{$locale}", 'like', "%{$term}%")
                );
        });
    }
    // Scope لجلب المشاريع حسب الفئة وحالة المشروع
    // Scope لجلب المشاريع الغير Draft
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'draft');
    }

    // Scope لجلب المشاريع حسب الفئة
    public function scopeOfCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Scope لجلب مجموع الاستثمارات مسبقاً
    public function scopeWithInvestmentsSum($query)
    {
        return $query->withSum('investments', 'amount');
    }

    /* =========================
     |  Accessors
     ========================= */

    public function getTitleAttribute()
    {
        return $this->translate('title');
    }

    public function getSummaryAttribute()
    {
        return $this->translate('summary');
    }

    public function getDescriptionAttribute()
    {
        return $this->translate('description');
    }

    public function getPercentageAttribute(): int
    {
        if ($this->funding_goal <= 0) {
            return 0;
        }

        return min(
            (int) round(($this->funded_amount / $this->funding_goal) * 100),
            100
        );
    }

    public function getStatusBadgeAttribute(): array
    {
        return [
            'label' => $this->status->label(),
            'class' => $this->status->badgeClass(),
        ];
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->funded_amount >= $this->funding_goal;
    }

    public function remaining()
    {
        return max($this->funding_goal - $this->funded_amount, 0);
    }

    public function financialDistribution()
    {
        return [
            'تطوير المنصة التقنية' => $this->funding_goal * 0.4,
            'المحتوى التعليمي' => $this->funding_goal * 0.25,
            'التسويق والترويج' => $this->funding_goal * 0.15,
            'التدريب والدعم الفني' => $this->funding_goal * 0.1,
            'التكاليف الإدارية' => $this->funding_goal * 0.1,
        ];
    }
    public function getFinancialPlanAttribute(): array
    {
        $years = ['الأولى', 'الثانية', 'الثالثة'];
        $plan = [];

        $initialRevenue = $this->funding_goal * 0.3;
        $cost = $this->funding_goal * 0.25;

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

    public function scopeOfStatus($query, $status = null)
    {
        if (!$status || $status === 'all') {
            return $query; // إظهار كل المشاريع
        }

        // تحقق من صحة Enum
        try {
            $projectStatus = ProjectStatus::from($status);
            return $query->where('status', $projectStatus);
        } catch (\ValueError $e) {
            return $query; // إذا القيمة غير صحيحة، ارجع كل المشاريع
        }
    }



    /* =========================
     |  Status & Stages
     ========================= */

    public function stages(): array
    {
        return [
            'reviewed_at' => 'قيد المراجعة',
            'pre_approved_at' => 'تم الموافقة المبدئية',
            'open_for_investment_at' => 'مفتوح للاستثمار',
            'funded_at' => 'ممول بالكامل',
            'repayment_started_at' => 'في مرحلة السداد',
        ];
    }

    public function canChangeStatus(ProjectStatus $newStatus): bool
    {
        return $this->status->canTransitionTo($newStatus);
    }

    public static function stageResetMap(): array
    {
        return [
            ProjectStatus::Draft->value => [
                'reviewed_at',
                'pre_approved_at',
                'open_for_investment_at',
                'funded_at',
                'repayment_started_at',
            ],
            ProjectStatus::Pending->value => [
                'pre_approved_at',
                'open_for_investment_at',
                'funded_at',
                'repayment_started_at',
            ],
            ProjectStatus::Approved->value => [
                'open_for_investment_at',
                'funded_at',
                'repayment_started_at',
            ],
            ProjectStatus::Funding->value => [
                'funded_at',
                'repayment_started_at',
            ],
            ProjectStatus::Active->value => [
                'repayment_started_at',
            ],
            ProjectStatus::Completed->value => [],
            ProjectStatus::Defaulted->value => [],
        ];
    }

    /* =========================
     |  Relationships
     ========================= */

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    /* =========================
     |  Helpers
     ========================= */

    public function deleteImages(): void
    {
        $this->images->each(function ($img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        });

        if ($this->image) {
            Storage::disk('public')->delete($this->image);
        }
    }
    public static function homepageStats(): array
    {
        $stats = [
            'activeProjects'    => self::where('status', ProjectStatus::Active)->count(),
            'pendingProjects'   => self::where('status', ProjectStatus::Pending)->count(),
            'completedProjects' => self::where('status', ProjectStatus::Completed)->count(),
            'approvedProjects'  => self::where('status', ProjectStatus::Approved)->count(),
            'fundedProjects'    => self::where('status', ProjectStatus::Funding)->count(),

            'fundedAmount'      => self::sum('funded_amount'),
            'fundingGoal'       => self::sum('funding_goal'),
            'requiredFunding'   => self::where('status', ProjectStatus::Approved)->sum('funding_goal'),

            'totalCapital'      => Investment::sum('amount'),
        ];

        $stats['percentage'] = $stats['fundingGoal'] > 0
            ? round(($stats['fundedAmount'] / $stats['fundingGoal']) * 100)
            : 0;

        return $stats;
    }

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
