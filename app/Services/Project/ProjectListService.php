<?php

namespace App\Services\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectListService
{
    public function execute(Request $request): LengthAwarePaginator
    {
        return Project::query()
            ->with(['parent'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->search($request->q);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // 🔥 مهم جدًا
    }
}
