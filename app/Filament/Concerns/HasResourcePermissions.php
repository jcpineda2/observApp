<?php

namespace App\Filament\Concerns;

<<<<<<< HEAD
use Filament\Resources\Resource;
=======
use Illuminate\Database\Eloquent\Model;
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait HasResourcePermissions
{
    /**
<<<<<<< HEAD
     * Devuelve el subject base del permiso.
     * Puede sobreescribirse en el Resource.
     */
    public static function permissionSubject(): string
    {
        /**
         * Por defecto:
         * - Deriva del nombre del modelo
         * - Convierte a snake_case
         * - Lo pluraliza
         *
         * Ej:
         * AccommodationCategory => accommodation_categories
         * EntryMode => entry_modes
         */
        $model = static::getModel();

        return Str::plural(Str::snake(class_basename($model)));
    }

    /**
     * Construye el nombre completo del permiso.
     * Ej: accommodation_categories.viewAny
     */
    public static function permissionName(string $ability): string
    {
        return static::permissionSubject() . '.' . $ability;
    }

    /**
     * Verifica si el usuario autenticado tiene permiso.
     */
    protected static function canPerform(string $ability): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return $user->can(static::permissionName($ability));
    }

    /* =========================
       Métodos que Filament usa
       ========================= */

    public static function canViewAny(): bool
    {
        return static::canPerform('viewAny');
    }

    public static function canView($record): bool
    {
        return static::canPerform('view');
=======
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
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0
    }

    public static function canCreate(): bool
    {
<<<<<<< HEAD
        return static::canPerform('create');
=======
        return static::allowed('create');
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0
    }

    public static function canEdit(Model $record): bool
    {
<<<<<<< HEAD
        return static::canPerform('update');
=======
        return static::allowed('update');
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0
    }

    public static function canDelete(Model $record): bool
    {
<<<<<<< HEAD
        return static::canPerform('delete');
=======
        return static::allowed('delete');
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0
    }

    public static function canDeleteAny(): bool
    {
<<<<<<< HEAD
        return static::canPerform('deleteAny');
=======
        return static::allowed('delete');
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0
    }
}
