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
        //Permissions
        $permission = Permission::create(['name' => 'roles.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'roles.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'roles.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'roles.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'roles.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'roles.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'roles.edit'])->syncRoles(['Admin']);
        
        //menu
        $permission = Permission::create(['name' => 'menu.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menu.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menu.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menu.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menu.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menu.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menu.edit'])->syncRoles(['Admin']);
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
        $permission = Permission::create(['name' => 'menuportipopaciente.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menuportipopaciente.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menuportipopaciente.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menuportipopaciente.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menuportipopaciente.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menuportipopaciente.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'menuportipopaciente.edit'])->syncRoles(['Admin']);
        //comidaportipopaciente
        $permission = Permission::create(['name' => 'comidaportipopaciente.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidaportipopaciente.edit'])->syncRoles(['Admin']);
        //alimentos
        $permission = Permission::create(['name' => 'alimentos.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentos.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentos.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentos.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentos.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentos.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentos.edit'])->syncRoles(['Admin']);
        //alimentosporproveedor
        $permission = Permission::create(['name' => 'alimentosporproveedor.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporproveedor.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporproveedor.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporproveedor.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporproveedor.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporproveedor.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporproveedor.edit'])->syncRoles(['Admin']);
        //comidas
        $permission = Permission::create(['name' => 'comidas.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidas.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidas.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidas.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidas.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidas.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'comidas.edit'])->syncRoles(['Admin']);

        //alimentosporcomida
        $permission = Permission::create(['name' => 'alimentosporcomida.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporcomida.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporcomida.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporcomida.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporcomida.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporcomida.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'alimentosporcomida.edit'])->syncRoles(['Admin']);
       
        //nutrientesporalimento
        $permission = Permission::create(['name' => 'nutrientesporalimento.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'nutrientesporalimento.edit'])->syncRoles(['Admin']);
        //relevamientos
        $permission = Permission::create(['name' => 'relevamientos.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'relevamientos.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'relevamientos.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'relevamientos.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'relevamientos.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'relevamientos.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'relevamientos.edit'])->syncRoles(['Admin']);
        //detallesrelevamiento
        $permission = Permission::create(['name' => 'detallesrelevamiento.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detallesrelevamiento.edit'])->syncRoles(['Admin']);
        //detallesrelevamiento
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'detrelevamientoporcomida.edit'])->syncRoles(['Admin']);
        //historial
        $permission = Permission::create(['name' => 'historial.elegirMenu'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'historial.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'historial.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'historial.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'historial.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'historial.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'historial.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'historial.edit'])->syncRoles(['Admin']);
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
        //permisos
        $permission = Permission::create(['name' => 'permisos.store'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'permisos.index'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'permisos.create'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'permisos.update'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'permisos.show'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'permisos.destroy'])->syncRoles(['Admin']);
        $permission = Permission::create(['name' => 'permisos.edit'])->syncRoles(['Admin']);
        
    }
}
