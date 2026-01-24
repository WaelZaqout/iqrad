<?php

namespace App\Models;

use App\Traits\HasLocale;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasLocale;
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


    // لتسهيل ترتيب المراحل
    public function stages()
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


    public function scopeSearch($query, ?string $term)
    {
        if (!$term) {
            return $query;
        }

        $locale = app()->getLocale(); // ar أو en

        return $query->where(function ($q) use ($term, $locale) {

            $q->where("title_{$locale}", 'like', "%{$term}%")

                ->orWhereHas('borrower', function ($borrowerQuery) use ($term) {
                    $borrowerQuery->where('name', 'like', "%{$term}%");
                })

                ->orWhereHas('category', function ($categoryQuery) use ($term, $locale) {
                    $categoryQuery->where("name_{$locale}", 'like', "%{$term}%");
                });
        });
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
    public function scopeVisibleTo($query, $user)
    {
        // زائر
        if (!$user) {
            return $query;
        }

        // مقترض → مشاريعه فقط
        if ($user->hasRole('borrower')) {
            return $query->where('borrower_id', $user->id);
        }

        // مستثمر / أدمن → كل المشاريع
        return $query;
    }

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

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
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




    public function getIsCompletedAttribute()
    {
        return $this->funded_amount >= $this->funding_goal;
    }
    public function deleteImages()
    {
        $this->images->each(function ($img) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image);
            $img->delete();
        });

        if ($this->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($this->image);
        }
    }
}
