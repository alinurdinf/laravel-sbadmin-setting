<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User as ModelsUser;
use App\User;
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
        $this->call(LaratrustSeeder::class);

        // SADMIN role
        $sadminrole = Role::create([
            'name' => 'sadmin',
            'display_name' => 'SUPER ADMINISTRATOR',
            'description' => 'SUPER ADMINISTRATOR',
        ]);

        $sadmin = ModelsUser::create([
            'name' => 'Super',
            'last_name' => 'Administrator',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $sadmin->syncRolesWithoutDetaching([$sadminrole]);
    }
}
