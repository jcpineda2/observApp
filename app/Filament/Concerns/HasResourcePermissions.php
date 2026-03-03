<?php

namespace App\Filament\Concerns;

use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait HasResourcePermissions
{
    /**
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
    }

    public static function canCreate(): bool
    {
        return static::canPerform('create');
    }

    public static function canEdit($record): bool
    {
        return static::canPerform('update');
    }

    public static function canDelete($record): bool
    {
        return static::canPerform('delete');
    }

    public static function canDeleteAny(): bool
    {
        return static::canPerform('deleteAny');
    }
}
