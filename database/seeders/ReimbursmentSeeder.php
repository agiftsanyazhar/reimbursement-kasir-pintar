<?php

namespace Database\Seeders;

use App\Models\Reimbursment;
use Illuminate\Database\Seeder;

class ReimbursmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reimbursment = [
            [
                'user_id' => '3',
                'date' => '2024-07-24',
                'name' => 'Lorem Ipsum 1',
                'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Suscipit labore eum voluptatem laborum expedita nobis incidunt porro sunt Lorem Ipsum 1',
                'date' => '2024-07-24',
                'file' => 'uploads/reimbursment/lorem-ipsum-1.png',
            ],
        ];

        foreach ($reimbursment as $item) {
            Reimbursment::create($item);
        }
    }
}
