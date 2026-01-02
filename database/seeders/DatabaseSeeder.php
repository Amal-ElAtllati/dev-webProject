<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\ResourceCategory;
use App\Models\Resource;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Roles
        $roles = [
            ['name' => 'admin'],
            ['name' => 'responsable'],
            ['name' => 'user'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }

        // Seed Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'active' => true,
            ]
        );
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$admin->roles()->where('role_id', $adminRole->id)->exists()) {
            $admin->roles()->attach($adminRole->id);
        }

        // Seed Responsable User
        $responsable = User::firstOrCreate(
            ['email' => 'responsable@example.com'],
            [
                'name' => 'Responsable Technique',
                'password' => Hash::make('password'),
                'role' => 'responsable',
                'active' => true,
            ]
        );
        $responsableRole = Role::where('name', 'responsable')->first();
        if ($responsableRole && !$responsable->roles()->where('role_id', $responsableRole->id)->exists()) {
            $responsable->roles()->attach($responsableRole->id);
        }

        // Seed Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'active' => true,
            ]
        );
        $userRole = Role::where('name', 'user')->first();
        if ($userRole && !$user->roles()->where('role_id', $userRole->id)->exists()) {
            $user->roles()->attach($userRole->id);
        }

        // Seed Resource Categories
        $categories = [
            ['name' => 'Serveurs'],
            ['name' => 'Ordinateurs'],
            ['name' => 'Réseaux'],
            ['name' => 'Périphériques'],
        ];

        foreach ($categories as $category) {
            ResourceCategory::firstOrCreate(['name' => $category['name']], $category);
        }

        // Seed Sample Resources
        $serveursCategory = ResourceCategory::where('name', 'Serveurs')->first();
        $ordisCategory = ResourceCategory::where('name', 'Ordinateurs')->first();

        if ($serveursCategory && $responsable) {
            Resource::firstOrCreate(
                ['nom' => 'Serveur Web 01'],
                [
                    'description' => 'Serveur web principal',
                    'cpu' => 8,
                    'ram' => 32,
                    'capacite' => 500,
                    'os' => 'Ubuntu Server 22.04',
                    'etat' => 'disponible',
                    'emplacement' => 'Salle serveur A',
                    'categorie_id' => $serveursCategory->id,
                    'responsable_id' => $responsable->id,
                ]
            );

            Resource::firstOrCreate(
                ['nom' => 'Serveur Base de Données'],
                [
                    'description' => 'Serveur MySQL/MariaDB',
                    'cpu' => 16,
                    'ram' => 64,
                    'capacite' => 1000,
                    'os' => 'Ubuntu Server 22.04',
                    'etat' => 'disponible',
                    'emplacement' => 'Salle serveur B',
                    'categorie_id' => $serveursCategory->id,
                    'responsable_id' => $responsable->id,
                ]
            );
        }

        if ($ordisCategory && $responsable) {
            Resource::firstOrCreate(
                ['nom' => 'PC Bureau 01'],
                [
                    'description' => 'Ordinateur de bureau standard',
                    'cpu' => 4,
                    'ram' => 16,
                    'capacite' => 256,
                    'os' => 'Windows 11',
                    'etat' => 'disponible',
                    'emplacement' => 'Bureau 101',
                    'categorie_id' => $ordisCategory->id,
                    'responsable_id' => $responsable->id,
                ]
            );
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Test credentials:');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('Responsable: responsable@example.com / password');
        $this->command->info('User: user@example.com / password');
    }
}
