<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'write articles']);
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'editor'])
            ->givePermissionTo([ 'write articles', 'edit articles', 'delete articles', 'publish articles', 'unpublish articles']);
        $role = Role::create(['name' => 'author'])
            ->givePermissionTo([ 'write articles', 'edit articles', 'delete articles', 'publish articles', 'unpublish articles']);
        $role = Role::create(['name' => 'contributor'])
            ->givePermissionTo([ 'write articles', 'edit articles', 'delete articles']);
        $role = Role::create(['name' => 'subscriber']);
	
		// Assign first user role to super-admin
		$superadmin = User::find(1);
		$superadmin->assignRole('super-admin');


    }
}