<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Illuminate\Database\Seeder;


class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(['name' => 'usuarios.index'],['description'=>'Indice de usuarios']);
        Permission::firstOrCreate(['name' => 'usuarios.show'],['description'=>'Detalles del usuario']);
        Permission::firstOrCreate(['name' => 'usuarios.create'],['description'=>'Creación de un nuevo usuario']);
        Permission::firstOrCreate(['name' => 'usuarios.edit'],['description'=>'Edición del usuario']);
        Permission::firstOrCreate(['name' => 'usuarios.delete'],['description'=>'Eliminar Usuario']);

        //roles
        Permission::firstOrCreate(['name' => 'roles.index'],['description'=>'Indice de Roles']);
        Permission::firstOrCreate(['name' => 'roles.show'],['description'=>'Detalles del rol']);
        Permission::firstOrCreate(['name' => 'roles.create'],['description'=>'Creación de un nuevo rol']);
        Permission::firstOrCreate(['name' => 'roles.edit'],['description'=>'Edición del rol']);
        Permission::firstOrCreate(['name' => 'roles.delete'],['description'=>'Eliminar rol']);

        $role = Role::firstOrCreate(['name' => 'Administrador'],['description'=>'Administrador del sistema']);
   		$role->syncPermissions(Permission::all());

        $user = User::findOrFail(1);
        $user->assignRole('Administrador');

        $role = Role::firstOrCreate(['name' => 'Vendedor'],['description'=>'Vendedor']);
        
    }
}
