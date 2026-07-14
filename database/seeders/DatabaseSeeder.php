<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeds the initial content set carried over from the static site so there's
 * no content regression at launch (requirements MG1).
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'oheneadjei.dev@gmail.com'],
            [
                'name' => 'Ohene Adjei',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            ProjectSeeder::class,
            BlogSeeder::class,
            SettingSeeder::class,
            LegacyRedirectSeeder::class,
        ]);
    }
}
