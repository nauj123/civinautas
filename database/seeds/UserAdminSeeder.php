<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
    		'primer_nombre' => 'Admin',
    		'primer_apellido' => 'User',
    		'fk_tipo_documento' => 1,
    		'identificacion' => '123456789'
    		'fk_departamento' => 8,
    		'fk_municipio' => 1,
    		'direccion' => 'Carrera',
    		'barrio' => 'sucre',
    		'email' => 'admin@email.com',
    		'fk_rol' => 172,
    		'password' => Hash::make('Admin@123')
    	]);
    }
}
