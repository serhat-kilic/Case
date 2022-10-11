<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'name' => 'Fatma',
            'surname' => 'KILIÇ',
            'email' => 'deneme@gmail.com',
            'sex'=>'female',
            'age'=>'32',
        ]);
    }
}
