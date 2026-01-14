<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CategoryService
{

    public function create(array $data): Category
    {
        return DB::transaction(function () use ($data) {

            $data['slug'] = $this->generateSlug($data['name']);


            // رفع الصورة (إن وُجدت)
            $category = Category::create(collect($data)->except(['image'])->toArray());

            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                $category->update([
                    'image' => $data['image']->store('categories', 'public')
                ]);
            }
            Log::info('Category created', [
                'category_id'  => $category->id,
            ]);

            return $category;
        });
        // إنشاء القسم
    }
    public function update(Category $category, array $data): Category
    {
        return DB::transaction(function () use ($category, $data) {

            // تحديث الـ slug عند تغيير العنوان
            if (!empty($data['name']) && $data['name'] !== $category->name) {
                $data['slug'] = $this->generateSlug($data['name'], $category->id);
            }

            // تحديث البيانات الأساسية
            $category->update(collect($data)->except(['image'])->toArray());

            // تحديث الصورة (إن وُجدت)
            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $category->update([
                    'image' => $data['image']->store('categories', 'public')
                ]);
            }

            Log::info('Category updated', [
                'category_id' => $category->id,
            ]);

            return $category;
        });
    }
    private function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);

        $query = Category::where('slug', 'like', "{$slug}%");

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $count = $query->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }
}
