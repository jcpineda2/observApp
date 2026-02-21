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

        $permissions = [
            // Inbound
            'inbound_tourisms.view',
            'inbound_tourisms.create',
            'inbound_tourisms.update',
            'inbound_tourisms.delete',

            // Domestic
            'domestic_tourisms.view',
            'domestic_tourisms.create',
            'domestic_tourisms.update',
            'domestic_tourisms.delete',

            // Accommodation Performance
            'accommodation_performances.view',
            'accommodation_performances.create',
            'accommodation_performances.update',
            'accommodation_performances.delete',

            // Connectivity Indicator
            'connectivity_indicators.view',
            'connectivity_indicators.create',
            'connectivity_indicators.update',
            'connectivity_indicators.delete',

            // Provider Indicator
            'provider_indicators.view',
            'provider_indicators.create',
            'provider_indicators.update',
            'provider_indicators.delete',

            // Employment + Demographics
            'tourism_employments.view',
            'tourism_employments.create',
            'tourism_employments.update',
            'tourism_employments.delete',

            'employment_demographics.view',
            'employment_demographics.create',
            'employment_demographics.update',
            'employment_demographics.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin  = Role::firstOrCreate(['name' => 'Admin']);
        $editor = Role::firstOrCreate(['name' => 'Editor']);
        $viewer = Role::firstOrCreate(['name' => 'Viewer']);

        // Admin: todo
        $admin->syncPermissions(Permission::all());

        // Editor: todo menos delete (recomendado para datos estadísticos)
        $editor->syncPermissions(array_filter($permissions, fn ($p) => ! str_ends_with($p, '.delete')));

        // Viewer: solo view
        $viewer->syncPermissions(array_filter($permissions, fn ($p) => str_ends_with($p, '.view')));
    }
}
