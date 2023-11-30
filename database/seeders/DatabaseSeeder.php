<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $systemRole = Role::create([
            'name' => 'system',
            'display_name' => 'SYSTEM ADMINISTRATOR',
            'description' => 'SYSTEM ADMINISTRATOR',
        ]);

        $dosenRole = Role::create([
            'name' => 'dosen',
            'display_name' => 'DOSEN',
            'description' => 'DOSEN',
        ]);

        $mahasiswaRole = Role::create([
            'name' => 'mahasiswa',
            'display_name' => 'MAHASISWA',
            'description' => 'MAHASISWA',
        ]);

        // USER role
        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'USER',
            'description' => 'USER',
        ]);

        // SADMIN role
        $sadminRole = Role::create([
            'name' => 'sadmin',
            'display_name' => 'SUPER ADMINISTRATOR',
            'description' => 'SUPER ADMINISTRATOR',
        ]);

        $sadmin = ModelsUser::create([
            'identity_number' => '0',
            'name' => 'Super',
            'last_name' => 'Administrator',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $sadmin->syncRolesWithoutDetaching([$sadminRole]);
    }
}
