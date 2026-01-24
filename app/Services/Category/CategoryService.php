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
    /**
     * إنشاء قسم جديد
     */
    public function create(array $data): Category
    {
        return DB::transaction(function () use ($data) {

            // توليد الـ slug باستخدام الاسم الإنجليزي فقط عند الإنشاء
            $data['slug'] = $this->generateSlug($data['name_en']);

            // إنشاء القسم بدون الصورة أولاً
            $category = Category::create(collect($data)->except(['image'])->toArray());

            // رفع الصورة إذا وُجدت
            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                $category->update([
                    'image' => $data['image']->store('categories', 'public')
                ]);
            }

            Log::info('Category created', [
                'category_id' => $category->id,
            ]);

            return $category;
        });
    }

    /**
     * تحديث قسم موجود
     */
    public function update(Category $category, array $data): Category
    {
        return DB::transaction(function () use ($category, $data) {

            // تحديث الـ slug عند تغيير الاسم
            if (!empty($data['name_en']) && $data['name_en'] !== $category->name_en) {
                $data['slug'] = $this->generateSlug($data['name_en'], $category->id);
            }

            // تحديث البيانات الأساسية بدون الصورة
            $category->update(collect($data)->except(['image'])->toArray());

            // تحديث الصورة إذا وُجدت
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

    /**
     * توليد slug فريد للقسم
     */
    private function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);

        $query = Category::where('slug', 'like', "{$slug}%");

        // تجاهل قسم موجود عند التحديث
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $count = $query->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }
}
