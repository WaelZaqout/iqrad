<?php

namespace App\Models;

use App\Traits\HasLocale;
use App\Enums\ProjectStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

    public function getPercentageAttribute()
    {
        return \App\Services\Front\FinancialCalculator::fundingPercentage(
            $this->funded_amount,
            $this->funding_goal
        );
    }
    public function getFundedAmountAttribute($value)
    {
        // إذا هناك قيمة مخزنة في العمود، استخدمها
        // إذا تريد حسابها ديناميكياً من الاستثمارات:
        return $this->investments()->sum('amount');
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
}
