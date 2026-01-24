<?php

namespace App\Services\Project;

use App\Models\Project;
use Illuminate\Support\Str;
use App\Enums\ProjectStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public function create(array $data, int $borrowerId): Project
    {
        return DB::transaction(function () use ($data, $borrowerId) {

            $data['borrower_id'] = $borrowerId;
            $data['status'] ??= ProjectStatus::Pending;
            $data['slug'] = $this->generateSlug($data['title_en']);

            $project = Project::create(collect($data)->except(['image', 'gallery'])->toArray());

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $project->update([
                    'image' => $data['image']->store('projects', 'public')
                ]);
            }

            if (!empty($data['gallery'])) {
                foreach ($data['gallery'] as $file) {
                    if ($file instanceof UploadedFile) {
                        $project->images()->create([
                            'image' => $file->store('projects/gallery', 'public')
                        ]);
                    }
                }
            }

            Log::info('Project created', [
                'project_id'  => $project->id,
                'borrower_id' => $borrowerId,
            ]);

            return $project;
        });
    }

    public function update(Project $project, array $data): Project
    {
        return DB::transaction(function () use ($project, $data) {

            // تحديث الـ slug عند تغيير العنوان
            if (!empty($data['title_en']) && $data['title_en'] !== $project->title_en) {
                $data['slug'] = $this->generateSlug($data['title_en'], $project->id);
            }

            // تحديث البيانات الأساسية
            $project->update(
                collect($data)->except(['image', 'gallery'])->toArray()
            );

            // تحديث الصورة الرئيسية
            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {

                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                }

                $project->update([
                    'image' => $data['image']->store('projects', 'public'),
                ]);
            }

            // تحديث Gallery
            if (!empty($data['gallery']) && is_array($data['gallery'])) {

                // حذف الصور القديمة من التخزين
                foreach ($project->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage->image);
                }

                // حذفها من قاعدة البيانات
                $project->images()->delete();

                // إضافة الصور الجديدة
                foreach ($data['gallery'] as $file) {
                    if ($file instanceof UploadedFile) {
                        $project->images()->create([
                            'image' => $file->store('projects/gallery', 'public'),
                        ]);
                    }
                }
            }

            return $project;
        });
    }


    private function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);

        $query = Project::where('slug', 'like', "{$slug}%");

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $count = $query->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }
    public function getStats(): array
    {
        $stats = Project::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'total'    => $stats->sum(),
            'pending'  => $stats[ProjectStatus::Pending->value]  ?? 0,
            'approved' => $stats[ProjectStatus::Approved->value] ?? 0,
        ];
    }
}
