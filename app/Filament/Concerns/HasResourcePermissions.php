<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait HasResourcePermissions
{
    protected static function getPermissionSubject(): string
    {
        if (property_exists(static::class, 'permissionSubject') && filled(static::$permissionSubject)) {
            return static::$permissionSubject;
        }

        $model = static::getModel();
        $base = class_basename($model);

        return Str::kebab(Str::pluralStudly($base));
    }

    protected static function permission(string $ability): string
    {
        return static::getPermissionSubject() . '.' . $ability;
    }

    protected static function allowed(string $ability): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if (method_exists($user, 'hasRole') && $user->hasRole('Admin')) {
            return true;
        }

        return $user->can(static::permission($ability));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }

    public static function canViewAny(): bool
    {
        return static::allowed('viewAny');
    }

    public static function canView(Model $record): bool
    {
        return static::allowed('view');
    }

    public static function canCreate(): bool
    {
        return static::allowed('create');
    }

    public static function canEdit(Model $record): bool
    {
        return static::allowed('update');
    }

    public static function canDelete(Model $record): bool
    {
        return static::allowed('delete');
    }

    public static function canDeleteAny(): bool
    {
        return static::allowed('delete');
    }
}
