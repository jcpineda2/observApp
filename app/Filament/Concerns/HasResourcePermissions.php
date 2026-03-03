<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait HasResourcePermissions
{
    /**
     * Subject para armar permisos.
     * Default: plural kebab del Model (AccommodationCategory => accommodation-categories)
     */
    protected static function getPermissionSubject(): string
    {
        $model = static::getModel();

        $base = class_basename($model);

        return Str::kebab(Str::pluralStudly($base));
    }

    protected static function permission(string $ability): string
    {
        return static::getPermissionSubject() . '.' . $ability;
    }

    /**
     * Reglas:
     * - Admin => todo
     * - Otros => según permisos Spatie
     */
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
