<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => ["Admin"],
        ]);
        $user1 = User::create([
            'name' => 'waiter',
            'email' => 'waiter@gmail.com',
            'password' => Hash::make('waiter123'),
            'role' => ["Waiter"],
        ]);
        $user2 = User::create([
            'name' => 'customar',
            'email' => 'castomar@gmail.com',
            'password' => Hash::make('castomar123'),
            'role' => ["Customer"],
        ]);

        $role = Role::create(['name' => 'Admin']);
        $roleCustomer = Role::create(['name' => 'Customer']);
        $roleWaiter = Role::create(['name' => 'Waiter']);
        $rolevisitor = Role::create(['name' => 'Visitor']);


        $permissions = Permission::pluck('id', 'id')->all();
        $permissionswaiter = Permission::whereBetween('id', [13, 29])->pluck('id')->all();

        $role->syncPermissions($permissions);
        $roleWaiter->syncPermissions($permissionswaiter);


        $user->assignRole($role->id);
        $user1->assignRole($roleWaiter->id);
        $user2->assignRole($roleCustomer->id);
    }
}
