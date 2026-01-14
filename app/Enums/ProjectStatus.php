<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Draft      = 'draft';
    case Pending    = 'pending';
    case Approved   = 'approved';
    case Funding    = 'funding';
    case Active     = 'active';
    case Completed  = 'completed';
    case Defaulted  = 'defaulted';

    public function label(): string
    {
        return match ($this) {
            self::Draft      => 'Draft',
            self::Pending    => 'Pending Review',
            self::Approved   => 'Pre-Approved',
            self::Funding    => 'Open for Funding',
            self::Active     => 'Active',
            self::Completed  => 'Completed',
            self::Defaulted  => 'Defaulted',
        };
    }
    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft      => 'secondary',
            self::Pending    => 'warning',
            self::Approved   => 'success',
            self::Funding    => 'info',
            self::Active     => 'primary',
            self::Completed  => 'success',
            self::Defaulted  => 'danger',
        };
    }

    public function canTransitionTo(self $newStatus): bool
    {
        return in_array($newStatus, match ($this) {
            self::Draft     => [self::Pending],
            self::Pending   => [self::Approved],
            self::Approved  => [self::Funding],
            self::Funding   => [self::Active],
            self::Active    => [self::Completed],
            default         => [],
        }, true);
    }
}
