<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleNutricion = Role::create(['name' => 'Nutricion']);
        $roleRelevamiento = Role::create(['name' => 'Relevamiento']);
        $roleAdminDespensa = Role::create(['name' => 'Despensa']);
        //Permissions
        $permission = Permission::create(['name' => 'roles.store'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'roles.index'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'roles.create'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'roles.update'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'roles.show'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'roles.destroy'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'roles.edit'])->syncRoles(['Admin','Nutricion']);
        
        //menu
        $permission = Permission::create(['name' => 'menu.store'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menu.index'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menu.create'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menu.update'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menu.show'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menu.destroy'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menu.edit'])->syncRoles(['Admin','Nutricion']);
        //salas
        $permission = Permission::create(['name' => 'salas.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'salas.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'salas.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'salas.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'salas.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'salas.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'salas.edit'])->syncRoles(['Admin']);
        //pacientes
        $permission = Permission::create(['name' => 'pacientes.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'pacientes.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'pacientes.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'pacientes.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'pacientes.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'pacientes.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'pacientes.edit'])->syncRoles(['Admin']);
        //empleados
        $permission = Permission::create(['name' => 'empleados.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'empleados.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'empleados.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'empleados.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'empleados.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'empleados.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'empleados.edit'])->syncRoles(['Admin']);
        //piezas
        $permission = Permission::create(['name' => 'piezas.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'piezas.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'piezas.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'piezas.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'piezas.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'piezas.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'piezas.edit'])->syncRoles(['Admin']);
        //camas
        $permission = Permission::create(['name' => 'camas.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'camas.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'camas.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'camas.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'camas.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'camas.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'camas.edit'])->syncRoles(['Admin']);
        //menuportipopaciente
        $permission = Permission::create(['name' => 'menuportipopaciente.store'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menuportipopaciente.index'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menuportipopaciente.create'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menuportipopaciente.update'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menuportipopaciente.show'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menuportipopaciente.destroy'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'menuportipopaciente.edit'])->syncRoles(['Admin','Nutricion']);
        //comidaportipopaciente
        $permission = Permission::create(['name' => 'comidaportipopaciente.store'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.index'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.create'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.update'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.show'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.destroy'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.edit'])->syncRoles(['Admin','Nutricion']);
        //alimentos
        $permission = Permission::create(['name' => 'alimentos.store'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentos.index'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentos.create'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentos.update'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentos.show'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentos.destroy'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentos.edit'])->syncRoles(['Admin','Despensa','Nutricion',]);
        //alimentosporproveedor
        $permission = Permission::create(['name' => 'alimentosporproveedor.store'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentosporproveedor.index'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentosporproveedor.create'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentosporproveedor.update'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentosporproveedor.show'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentosporproveedor.destroy'])->syncRoles(['Admin','Despensa','Nutricion',]);
        $permission = Permission::create(['name' => 'alimentosporproveedor.edit'])->syncRoles(['Admin','Despensa','Nutricion',]);
        //comidas
        $permission = Permission::create(['name' => 'comidas.store'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidas.index'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidas.create'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidas.update'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidas.show'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidas.destroy'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'comidas.edit'])->syncRoles(['Admin','Nutricion']);

        //alimentosporcomida
        $permission = Permission::create(['name' => 'alimentosporcomida.store'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'alimentosporcomida.index'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'alimentosporcomida.create'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'alimentosporcomida.update'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'alimentosporcomida.show'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'alimentosporcomida.destroy'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'alimentosporcomida.edit'])->syncRoles(['Admin','Nutricion']);
       
        //nutrientesporalimento
        $permission = Permission::create(['name' => 'nutrientesporalimento.store'])->syncRoles(['Admin','Despensa']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.index'])->syncRoles(['Admin','Despensa']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.create'])->syncRoles(['Admin','Despensa']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.update'])->syncRoles(['Admin','Despensa']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.show'])->syncRoles(['Admin','Despensa']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.destroy'])->syncRoles(['Admin','Despensa']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.edit'])->syncRoles(['Admin','Despensa']);
        //relevamientos
        $permission = Permission::create(['name' => 'relevamientos.store'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'relevamientos.index'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'relevamientos.create'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'relevamientos.update'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'relevamientos.show'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'relevamientos.destroy'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'relevamientos.edit'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        //detallesrelevamiento
        $permission = Permission::create(['name' => 'detallesrelevamiento.store'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.index'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.create'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.update'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.show'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.destroy'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.edit'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        //detallesrelevamiento
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.store'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.index'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.create'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.update'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.show'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.destroy'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.edit'])->syncRoles(['Admin','Nutricion','Relevamiento']);
        //historial
        $permission = Permission::create(['name' => 'historial.elegirMenu'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'historial.store'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'historial.index'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'historial.create'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'historial.update'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'historial.show'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'historial.destroy'])->syncRoles(['Admin','Nutricion']);
        $permission = Permission::create(['name' => 'historial.edit'])->syncRoles(['Admin','Nutricion']);
        //usuarios
        $permission = Permission::create(['name' => 'usuarios.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'usuarios.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'usuarios.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'usuarios.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'usuarios.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'usuarios.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'usuarios.edit'])->syncRoles(['Admin']);
        //proveedores
        $permission = Permission::create(['name' => 'proveedores.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'proveedores.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'proveedores.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'proveedores.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'proveedores.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'proveedores.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'proveedores.edit'])->syncRoles(['Admin']);
        //personas
        $permission = Permission::create(['name' => 'personas.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'personas.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'personas.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'personas.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'personas.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'personas.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'personas.edit'])->syncRoles(['Admin']);
        
    }
}
