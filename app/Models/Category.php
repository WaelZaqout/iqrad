<?php

namespace App\Models;

use App\Traits\HasLocale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, HasLocale;

    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'image',
        'description_en',
        'description_ar',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }


    public function scopeSearch($query, ?string $term)
    {
        if (!$term) return $query;
        $locale = app()->getLocale(); // ar أو en

        return $query->where(function ($q) use ($term, $locale) {
            $q->where("name_{$locale}", 'like', "%{$term}%")
                ->orWhereHas(
                    'parent',
                    fn($p) =>
                    $p->where("name_{$locale}", 'like', "%{$term}%")
                );
        });
    }
    public function scopeOrderedByLocale($query, $locale)
    {
        return $query->orderBy("name_$locale");
    }
    public function getNameAttribute()
    {
        return $this->translate('name');
    }
    public function getDescriptionAttribute()
    {
        return $this->translate('description');
    }
    public function deleteImages(): void
    {
        if ($this->image) {
            Storage::disk('public')->delete($this->image);
        }
    }
}
