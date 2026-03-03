<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // HABILIDADES alineadas al trait/Filament
        $abilities = ['viewAny', 'view', 'create', 'update', 'delete'];

        // SUBJECTS (deben coincidir con getPermissionSubject()).
        // Recomiendo definirlos explícitos para control total.
        $subjects = [
            'users',
            'roles',
            'permissions',

            'countries',
            'months',
            'years',

            'entry-modes',
            'travel-reasons',

            'service-sectors',
            'tourism-provider-stats',

            'accommodation-categories',
            'accommodations',
            'accommodation-performances',

            'air-lines',
            'airports',
            'air-connectivity-routes',

            'domestic-tourisms',
            'inbound-tourisms',

            'tourism-employments',
            'employment-demographics',
        ];

        $allPermissions = [];

        foreach ($subjects as $subject) {
            foreach ($abilities as $ability) {
                $allPermissions[] = "{$subject}.{$ability}";
            }
        }

        // Crear/actualizar permisos (idempotente)
        foreach ($allPermissions as $name) {
            Permission::updateOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                []
            );
        }

        // Roles
        $admin  = Role::updateOrCreate(['name' => 'Admin', 'guard_name' => 'web'], []);
        $editor = Role::updateOrCreate(['name' => 'Editor', 'guard_name' => 'web'], []);
        $viewer = Role::updateOrCreate(['name' => 'Visor', 'guard_name' => 'web'], []);

        // Admin: todo
        $admin->syncPermissions(Permission::all());

        // Editor: todo menos delete
        $editorPerms = array_filter($allPermissions, fn ($p) => ! str_ends_with($p, '.delete'));
        $editor->syncPermissions($editorPerms);

        // Visor: solo ver
        $viewerPerms = array_filter($allPermissions, fn ($p) =>
            str_ends_with($p, '.viewAny') || str_ends_with($p, '.view')
        );
        $viewer->syncPermissions($viewerPerms);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
