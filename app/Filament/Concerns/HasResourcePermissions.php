<?php

namespace App\Filament\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasResourcePermissions
{
    /**
     * Cada Resource debe definir este valor exactamente como el "módulo" usado en tus permisos.
     * Ej: 'roles', 'usuarios', 'turismo receptivo', 'desempeño de alojamiento'
     */

    protected static function currentUser(): ?User
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user;
    }

    protected static function permissionFor(string $action): string
    {
        // Mapeo acción -> verbo EXACTO que existe en tus permisos
        $verbs = [
            'view'   => 'Listar',
            'create' => 'Crear',
            'update' => 'Editar',
            'delete' => 'Borrar',
        ];

        $verb = $verbs[$action] ?? $action;

        return $verb . ' ' . mb_strtolower(static::$permissionSubject);
    }

    public static function canViewAny(): bool
    {
        return static::currentUser()?->can(static::permissionFor('view')) ?? false;
    }

    public static function canCreate(): bool
    {
        return static::currentUser()?->can(static::permissionFor('create')) ?? false;
    }

    public static function canEdit($record): bool
    {
        return static::currentUser()?->can(static::permissionFor('update')) ?? false;
    }

    public static function canDelete($record): bool
    {
        return static::currentUser()?->can(static::permissionFor('delete')) ?? false;
    }
}
