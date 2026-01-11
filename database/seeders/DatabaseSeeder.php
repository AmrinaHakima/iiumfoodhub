<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cafe;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
{
    DB::statement('PRAGMA foreign_keys = OFF;');
    Cafe::truncate();
    MenuItem::truncate();
    DB::statement('PRAGMA foreign_keys = ON;');

    // --- 1. FARUK-UTHMAN DINE (ID: 1) ---
    $faruk = Cafe::create([
        'id' => 1,
        'name' => 'Faruk-Uthman Dine',
        'location' => 'Mahallah Faruq & Uthman',
        'open_time' => '07:30:00',
        'close_time' => '21:00:00',
        'image_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=500&q=80'
    ]);

    $faruk->menuItems()->createMany([
        ['name' => 'Mee Tarik', 'price' => 8.00, 'category' => 'Food', 'description' => 'Savory beef broth.', 'image_url' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?auto=format&fit=crop&w=300&q=80'],
        ['name' => 'Teh Ais', 'price' => 2.00, 'category' => 'Drinks', 'description' => 'Classic iced tea.', 'image_url' => 'https://images.unsplash.com/photo-1594631252845-29fc458681b3?auto=format&fit=crop&w=300&q=80'],
    ]);

    // --- 2. CAFE HALIMAH (ID: 2) ---
    $halimah = Cafe::create([
        'id' => 2,
        'name' => 'Cafe Halimah',
        'location' => 'Mahallah Halimatus Saadiah',
        'open_time' => '08:00:00',
        'close_time' => '22:00:00',
        'image_url' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=500&q=80'
    ]);

    $halimah->menuItems()->createMany([
        ['name' => 'Nasi Lemak Ayam', 'price' => 6.50, 'category' => 'Food', 'description' => 'Fragrant coconut rice.', 'image_url' => 'https://images.unsplash.com/photo-1626074353765-517a681e40be?auto=format&fit=crop&w=300&q=80'],
        ['name' => 'Teh Ais Padu', 'price' => 2.50, 'category' => 'Drinks', 'description' => 'Creamy milk tea.', 'image_url' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=300&q=80'],
    ]);
}
}