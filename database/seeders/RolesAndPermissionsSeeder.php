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
            'listar usuarios',
            'Crear usuarios',
            'Editar usuarios',
            'Borrar usuarios',

            'listar permisos',
            'Crear permisos',
            'Editar permisos',
            'Borrar permisos',

            'listar roles',
            'Crear roles',
            'Editar roles',
            'Borrar roles',

            'listar Cagegorías',
            'Crear Cagegorías',
            'Editar Cagegorías',
            'Borrar Cagegorías',

            'listar Aerolineas',
            'Crear Aerolineas',
            'Editar Aerolineas',
            'Borrar Aerolineas',

            'listar Aeropuertos',
            'Crear Aeropuertos',
            'Editar Aeropuertos',
            'Borrar Aeropuertos',

            'listar Paises',
            'Crear Paises',
            'Editar Paises',
            'Borrar Paises',

            'listar Vía de ingresos',
            'Crear Vía de ingresos',
            'Editar Vía de ingresos',
            'Borrar Vía de ingresos',

            'listar Rubros',
            'Crear Rubros',
            'Editar Rubros',
            'Borrar Rubros',

            'listar Motivos de viaje',
            'Crear Motivos de viaje',
            'Editar Motivos de viaje',
            'Borrar Motivos de viaje',

            'listar Desempeño de alojamiento',
            'Crear Desempeño de alojamiento',
            'Editar Desempeño de alojamiento',
            'Borrar Desempeño de alojamiento',

            'listar Empleo turístico',
            'Crear Empleo turístico',
            'Editar Empleo turístico',
            'Borrar Empleo turístico',

            'listar Alojamientos',
            'Crear Alojamientos',
            'Editar Alojamientos',
            'Borrar Alojamientos',

            'listar Prestadores',
            'Crear Prestadores',
            'Editar Prestadores',
            'Borrar Prestadores',

            'listar Conectividad',
            'Crear Conectividad',
            'Editar Conectividad',
            'Borrar Conectividad',

            'listar Turismo interno',
            'Crear Turismo interno',
            'Editar Turismo interno',
            'Borrar Turismo interno',

            'listar Turismo receptivo',
            'Crear Turismo receptivo',
            'Editar Turismo receptivo',
            'Borrar Turismo receptivo',

            'listar Indicadores prestadores',
            'Crear  Indicadores prestadores',
            'Editar Indicadores prestadores',
            'Borrar Indicadores prestadores',

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
        $editor->syncPermissions(array_filter($permissions, fn($p) => ! str_ends_with($p, 'Borrar.')));

        // Viewer: solo view
        $viewer->syncPermissions(array_filter($permissions, fn($p) => str_ends_with($p, 'Listar.')));
    }
}
