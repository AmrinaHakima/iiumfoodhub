<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        $cafe = \App\Models\Cafe::create([
            'name' => 'Faruk-Uthman Dine',
            'location' => 'Mahallah Faruq',
            'open_time' => '08:00:00',
            'close_time' => '22:00:00',
        ]);

        $cafe->menuItems()->createMany([
            ['name' => 'Mee Tarik', 'price' => 8.00, 'category' => 'Food', 'description' => 'Hand-pulled noodles...'],
            ['name' => 'Teh Ais', 'price' => 2.00, 'category' => 'Drinks', 'description' => 'Iced tea with milk'],
        ]);
    }
}
