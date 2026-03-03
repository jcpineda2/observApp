<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

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
        ];

        $allPermissions = [];

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


        // admin: casi todo menos seguridad avanzada si querés
        $admin->syncPermissions(Permission::all());

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
    }
}
