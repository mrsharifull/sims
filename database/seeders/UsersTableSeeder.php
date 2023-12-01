<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'id' => 1,
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('admin@gmail.com'),
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        // Create Roles
        $roles = [
            1 => 'superadmin',
            2 => 'admin',
            3 => 'user',
        ];

        foreach ($roles as $roleId => $roleName) {
            Role::create(['id' => $roleId,'name' => $roleName]);
        }

        // Create Superadmin
        $superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@dev.com',
            'password' => Hash::make('superadmin@dev.com'),
            'role_id' => 1,
        ]);
        $superadmin->assignRole($superadmin->role->name);

        // Create Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@dev.com',
            'password' => Hash::make('admin@dev.com'),
            'role_id' => 2,
        ]);
        $admin->assignRole($admin->role->name);

        // Create User
        $user = User::create([
            'name' => 'User',
            'email' => 'user@dev.com',
            'password' => Hash::make('user@dev.com'),
            'role_id' => 3,
        ]);
        $user->assignRole($user->role->name);

    }
}
