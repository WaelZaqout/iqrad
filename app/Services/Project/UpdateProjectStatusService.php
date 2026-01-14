<?php

namespace App\Services\Project;

use App\Models\Project;
use App\Enums\ProjectStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdateProjectStatusService
{
    public function execute(Project $project, string $newStatus): Project
    {
        $newStatusEnum = ProjectStatus::from($newStatus);

        if ($project->status === $newStatusEnum) {
            return $project;
        }

        if (! $project->canChangeStatus($newStatusEnum)) {
            throw ValidationException::withMessages([
                'status' => 'Invalid project status transition.',
            ]);
        }

        return DB::transaction(function () use ($project, $newStatusEnum) {

            foreach (Project::stageResetMap()[$newStatusEnum->value] ?? [] as $column) {
                $project->{$column} = null;
            }

            $project->status = $newStatusEnum;

            match ($newStatusEnum) {
                ProjectStatus::Pending   => $project->reviewed_at ??= now(),
                ProjectStatus::Approved  => $project->pre_approved_at ??= now(),
                ProjectStatus::Funding   => $project->open_for_investment_at ??= now(),
                ProjectStatus::Active    => $project->funded_at ??= now(),
                ProjectStatus::Completed => $project->repayment_started_at ??= now(),
                default => null,
            };


            $project->save();

            return $project;
        });
    }
}
