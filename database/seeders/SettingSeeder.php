<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Seeds default site settings, including the "available for new projects"
 * toggle that the static hero currently hardcodes (requirements FR8).
 */
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::set('available_for_projects', '1');
    }
}
