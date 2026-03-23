<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $abilities = ['viewAny', 'view', 'create', 'update', 'delete'];

        $subjects = [
            // Seguridad
            'users',
            'roles',
            'permissions',
            'audit-logs',

            // Catálogos
            'countries',
            'months',
            'years',
            'entry-modes',
            'travel-reasons',
            'service-sectors',
            'accommodation-categories',
            'origin-regions',
            'age-ranges',
            'air-lines',
            'airports',
            'continents',
            'data-sources',

            // Observatorio
            'domestic-tourisms',
            'inbound-tourisms',
            'tourism-provider-stats',
            'accommodation-capacities',
            'accommodation-performances',
            'tourism-employments',
            'employment-demographics',
            'air-connectivity-routes',
            'indicator-constants',
        ];

        $allPermissions = [];

        foreach ($subjects as $subject) {
            foreach ($abilities as $ability) {
                $allPermissions[] = "{$subject}.{$ability}";
            }
        }

        foreach ($allPermissions as $name) {
            Permission::updateOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                []
            );
        }

        $admin = Role::updateOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web'],
            []
        );

        $editor = Role::updateOrCreate(
            ['name' => 'Editor', 'guard_name' => 'web'],
            []
        );

        $viewer = Role::updateOrCreate(
            ['name' => 'Visor', 'guard_name' => 'web'],
            []
        );

        $observer = Role::updateOrCreate(
            ['name' => 'Observador', 'guard_name' => 'web'],
            []
        );

        // Admin: todo
        $admin->syncPermissions(Permission::all());

        // Editor: todo menos delete
        $editorPerms = array_filter(
            $allPermissions,
            fn ($permission) => ! str_ends_with($permission, '.delete')
        );
        $editor->syncPermissions($editorPerms);

        // Visor: solo ver
        $viewerPerms = array_filter(
            $allPermissions,
            fn ($permission) =>
                str_ends_with($permission, '.viewAny') ||
                str_ends_with($permission, '.view')
        );
        $viewer->syncPermissions($viewerPerms);

        // Observador:
        // puede ver, crear y editar
        // NO puede borrar
        // NO tiene acceso a usuarios, roles ni permisos
        $restrictedSubjects = [
            'users',
            'roles',
            'permissions',
            'audit-logs',
        ];

        $observerPerms = array_filter(
            $allPermissions,
            function ($permission) use ($restrictedSubjects) {
                foreach ($restrictedSubjects as $subject) {
                    if (str_starts_with($permission, "{$subject}.")) {
                        return false;
                    }
                }

                return
                    str_ends_with($permission, '.viewAny') ||
                    str_ends_with($permission, '.view') ||
                    str_ends_with($permission, '.create') ||
                    str_ends_with($permission, '.update');
            }
        );

        $observer->syncPermissions($observerPerms);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
