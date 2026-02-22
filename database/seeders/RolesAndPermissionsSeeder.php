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

            'listar cagegorías',
            'Crear cagegorías',
            'Editar cagegorías',
            'Borrar cagegorías',

            'listar aerolineas',
            'Crear aerolineas',
            'Editar aerolineas',
            'Borrar aerolineas',

            'listar aeropuertos',
            'Crear aeropuertos',
            'Editar aeropuertos',
            'Borrar aeropuertos',

            'listar paises',
            'Crear paises',
            'Editar paises',
            'Borrar paises',

            'listar vía de ingresos',
            'Crear vía de ingresos',
            'Editar vía de ingresos',
            'Borrar vía de ingresos',

            'listar rubros',
            'Crear rubros',
            'Editar rubros',
            'Borrar rubros',

            'listar motivos de viaje',
            'Crear motivos de viaje',
            'Editar motivos de viaje',
            'Borrar motivos de viaje',

            'listar desempeño de alojamiento',
            'Crear desempeño de alojamiento',
            'Editar desempeño de alojamiento',
            'Borrar desempeño de alojamiento',

            'listar empleo turístico',
            'Crear empleo turístico',
            'Editar empleo turístico',
            'Borrar empleo turístico',

            'listar alojamientos',
            'Crear alojamientos',
            'Editar alojamientos',
            'Borrar alojamientos',

            'listar prestadores',
            'Crear prestadores',
            'Editar prestadores',
            'Borrar Prestadores',

            'listar conectividad',
            'Crear conectividad',
            'Editar conectividad',
            'Borrar conectividad',

            'listar turismo interno',
            'Crear turismo interno',
            'Editar turismo interno',
            'Borrar turismo interno',

            'listar turismo receptivo',
            'Crear turismo receptivo',
            'Editar turismo receptivo',
            'Borrar turismo receptivo',

            'listar indicadores prestadores',
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
