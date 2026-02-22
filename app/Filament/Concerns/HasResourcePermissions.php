<?php

namespace App\Filament\Concerns;

trait HasResourcePermissions
{
    protected static function perm(string $action): string
    {
        return $action . '_' . static::$permissionResource;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can(static::perm('view')) ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can(static::perm('create')) ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can(static::perm('update')) ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can(static::perm('delete')) ?? false;
    }
}
