<?php

namespace Database\Seeders;

use App\Models\EmployeeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'REGULAR'],
            ['name' => 'PROBATIONARY'],
            ['name' => 'MATERNITY LEAVE'],
            ['name' => 'PROJECT BASED'],
        ];

        foreach($statuses as $status) {
            EmployeeStatus::updateOrCreate(
                ['name' => $status['name']],
                $status
            );
        }
    }
}
