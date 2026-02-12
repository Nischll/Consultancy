<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
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
        // Seed basic roles first
        $roles = ['Super Admin', 'Admin', 'Editor', 'Student', 'Employee', 'Teacher', 'HR', 'Counselor'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['role' => $role]);
        }
        
        // Create basic admin user
        User::firstOrCreate(
            ['email' => 'admin@consultancy2.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role_id' => 1,
                'email_verified_at' => now(),
            ]
        );

        // Seed demo data
        $this->call([
            DemoDataSeeder::class,
        ]);
    }
}
