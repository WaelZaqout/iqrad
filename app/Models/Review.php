<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // العلاقات
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // آخر المراجعات للصفحة الرئيسية
    public static function homepage(int $limit = 10)
    {
        return self::with(['user', 'project'])
            ->latest()
            ->take($limit)
            ->get();
    }

    // متوسط التقييمات لجميع المشاريع
    public static function averageRating()
    {
        return round(self::avg('rating'), 1);
    }

    // عدد التقييمات لجميع المشاريع
    public static function ratingsCount()
    {
        return self::count();
    }
}
