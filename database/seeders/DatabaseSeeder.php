<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeds the initial content set carried over from the static site so there's
 * no content regression at launch (requirements MG1). The admin user is created
 * separately via `php artisan make:filament-user`, not seeded, to avoid shipping
 * known credentials.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProjectSeeder::class,
            BlogSeeder::class,
            SettingSeeder::class,
            LegacyRedirectSeeder::class,
        ]);
    }
}
