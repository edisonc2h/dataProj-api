<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create(['name' => 'Administrador', 'path' => '/dashboard/default']);
        Menu::create(['name' => 'Portal', 'path' => '/portal']);
        Menu::create(['name' => 'Consultas', 'path' => '/queries']);
        Menu::create(['name' => 'Descarga', 'path' => '/downloads']);
        Menu::create(['name' => 'Consulta SB', 'path' => '/queriesSb']);
        Menu::create(['name' => 'Consulta SEPS', 'path' => '/queriesSeps']);
    }
}
