<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
<<<<<<< HEAD
use Spatie\Permission\Models\Role;
=======
use Illuminate\Support\Arr;
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

<<<<<<< HEAD
        $map = [
            'roles' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'permissions' => ['viewAny', 'view'],

            'users' => ['viewAny', 'view', 'create', 'update', 'delete'],

            'countries' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'entry_modes' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'travel_reasons' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'service_sectors' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'accommodation_categories' => ['viewAny', 'view', 'create', 'update', 'delete'],

            'accommodations' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'accommodation_performances' => ['viewAny', 'view', 'create', 'update', 'delete'],

            'inbound_tourisms' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'domestic_tourisms' => ['viewAny', 'view', 'create', 'update', 'delete'],

            'tourism_employments' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'employment_demographics' => ['viewAny', 'view', 'create', 'update', 'delete'],

            'air_connectivity_routes' => ['viewAny', 'view', 'create', 'update', 'delete'],
            'air_lines' => ['viewAny', 'view', 'create', 'update', 'delete'],

            'tourism_provider_stats' => ['viewAny', 'view', 'create', 'update', 'delete'],
=======
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
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0
        ];

        $allPermissions = [];

<<<<<<< HEAD
        foreach ($map as $subject => $abilities) {
            foreach ($abilities as $ability) {
                $allPermissions[] = Permission::firstOrCreate([
                    'name' => "{$subject}.{$ability}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // 2) Roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $viewer = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
=======
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
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0


        // admin: casi todo menos seguridad avanzada si querés
        $admin->syncPermissions(Permission::all());

<<<<<<< HEAD
        $securitySubjects = ['users', 'roles', 'permissions'];

        // editor: puede crear/editar/ver, pero no borrar
        $editor = Permission::whereNotIn('name', collect($securitySubjects)->flatMap(fn($s) => [
            "$s.viewAny",
            "$s.view",
            "$s.create",
            "$s.update",
            "$s.delete"
        ]))
            ->where(function ($query) {
                // Aquí mantienes tu lógica de que el editor no borra
                $query->where('name', 'not like', '%.delete');
            })
            ->get();

        // viewer: solo lectura
        $viewer->syncPermissions(Permission::where('name', 'like', '%.viewAny')
            ->orWhere('name', 'like', '%.view')
            ->get());
=======
        // Editor: todo menos delete
        $editorPerms = array_filter($allPermissions, fn ($p) => ! str_ends_with($p, '.delete'));
        $editor->syncPermissions($editorPerms);

        // Visor: solo ver
        $viewerPerms = array_filter($allPermissions, fn ($p) =>
            str_ends_with($p, '.viewAny') || str_ends_with($p, '.view')
        );
        $viewer->syncPermissions($viewerPerms);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
>>>>>>> 35daae756bbc6bc4c07359cc03a8aef9240a4ca0
    }
}
