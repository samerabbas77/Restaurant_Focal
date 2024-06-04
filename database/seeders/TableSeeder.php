<?php

namespace Database\Seeders;

use App\Models\Table;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = Table::create([
            'Number' => '1',
            'chair_number' => '10',
        ]);
  
    }
}
