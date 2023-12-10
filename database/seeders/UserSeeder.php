<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'root@dataproj.com')->first();
        if(empty($user)) {
            User::create([
                'username' => 'root',
                'name' => 'Administrador',
                'lastname' => 'DataProj',
                'documentNumber' => '',
                'status' => 'Activo',
                'financialInstitution' => '.',
                'portalDownload' => 'Si',
                'consultingJudicialOrders' => 'Si',
                'email' => 'root@dataproj.com',
                'password' => Hash::make('1qaz2wsx'),
                'profile_id' => '1'
            ]);
        }
    }
}
