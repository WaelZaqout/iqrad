<?php

namespace App\Services\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectListService
{
    public function execute(Request $request, bool $ignoreVisibility = false): LengthAwarePaginator
    {
        return Project::query()
            ->with(['borrower', 'category'])
            ->when(!$ignoreVisibility, fn($q) => $q->visibleTo(Auth::user()))
            ->when($request->filled('q'), fn($q) => $q->search($request->q))
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }
}
