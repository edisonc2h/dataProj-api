<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = Profile::where('code', 'Admin')->first();
        if(empty($profile)) {
            Profile::create([
                'code' => 'Admin',
                'description' => 'Administrador',
                'menu' => '[
                {"name": "ADMINSTRADOR -> Perfil", "path": "/profiles", "selected": true},
                {"name": "ADMINSTRADOR -> Crear Perfil", "path": "/profiles/new", "selected": true},
                {"name": "ADMINSTRADOR -> Usuarios", "path": "/users", "selected": true},
                {"name": "ADMINSTRADOR -> Crear Usuarios", "path": "/users/new", "selected": true},
                {"name": "PORTAL", "path": "/portal", "selected": true},
                {"name": "CONSULTAS", "path": "/consultas", "selected": true},
                {"name": "DESCARGA", "path": "/downloads", "selected": true},
                {"name": "CONSULTA SB", "path": "/consulta_sb", "selected": true},
                {"name": "CONSULTA SEPS", "path": "/consulta_seps", "selected": true}
                ]'
            ]);
        }
    }
}
