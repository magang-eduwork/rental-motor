<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::updateOrCreate(
            ['key' => 'hero_image_url'],
            ['value' => 'https://i.ibb.co.com/Lh9d84PX/a44f9055b40db9210198bda81452bbb436eb019d.jpg']
        );
    }
}
