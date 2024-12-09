<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10)
        ];

        DB::beginTransaction();
        try{
            $user = User::create(array_merge([
                'name' => 'Admin',
                'email' => 'admin@dev.com',
            ],$default_user_value));

            $role_user = Role::create(['name' => 'admin']);
            $permission = Permission::create(['name' => 'dashboard admin']);
            $role_user->givePermissionTo($permission);
            $user->assignRole($role_user);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
