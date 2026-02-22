<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'Listar usuarios',
            'Crear usuarios',
            'Editar usuarios',
            'Borrar usuarios',

            'Listar permisos',
            'Crear permisos',
            'Editar permisos',
            'Borrar permisos',

            'Listar roles',
            'Crear roles',
            'Editar roles',
            'Borrar roles',

            'Listar categorías',
            'Crear categorías',
            'Editar categorías',
            'Borrar categorías',

            'Listar aerolineas',
            'Crear aerolineas',
            'Editar aerolineas',
            'Borrar aerolineas',

            'Listar aeropuertos',
            'Crear aeropuertos',
            'Editar aeropuertos',
            'Borrar aeropuertos',

            'Listar paises',
            'Crear paises',
            'Editar paises',
            'Borrar paises',

            'Listar vía de ingresos',
            'Crear vía de ingresos',
            'Editar vía de ingresos',
            'Borrar vía de ingresos',

            'Listar rubros',
            'Crear rubros',
            'Editar rubros',
            'Borrar rubros',

            'Listar motivos de viaje',
            'Crear motivos de viaje',
            'Editar motivos de viaje',
            'Borrar motivos de viaje',

            'Listar desempeño de alojamiento',
            'Crear desempeño de alojamiento',
            'Editar desempeño de alojamiento',
            'Borrar desempeño de alojamiento',

            'Listar empleo turístico',
            'Crear empleo turístico',
            'Editar empleo turístico',
            'Borrar empleo turístico',

            'Listar alojamientos',
            'Crear alojamientos',
            'Editar alojamientos',
            'Borrar alojamientos',

            'Listar prestadores',
            'Crear prestadores',
            'Editar prestadores',
            'Borrar prestadores',

            'Listar conectividad',
            'Crear conectividad',
            'Editar conectividad',
            'Borrar conectividad',

            'Listar turismo interno',
            'Crear turismo interno',
            'Editar turismo interno',
            'Borrar turismo interno',

            'Listar turismo receptivo',
            'Crear turismo receptivo',
            'Editar turismo receptivo',
            'Borrar turismo receptivo',

            'Listar indicadores prestadores',
            'Crear indicadores prestadores',
            'Editar indicadores prestadores',
            'Borrar indicadores prestadores',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin  = Role::firstOrCreate(['name' => 'Admin']);
        $editor = Role::firstOrCreate(['name' => 'Editor']);
        $viewer = Role::firstOrCreate(['name' => 'Visor']);

        // Admin: todo
        $admin->syncPermissions(Permission::all());

        // Editor: todo menos delete (recomendado para datos estadísticos)
        $editor->syncPermissions(array_filter($permissions, fn($p) => !Str::contains(strtolower($p), 'borrar')));

        // Viewer: solo view
        $viewer->syncPermissions(array_filter($permissions, fn($p) => Str::contains(strtolower($p), 'listar')));
    }
}
