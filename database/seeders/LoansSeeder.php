<?php

namespace Database\Seeders;

use App\Models\Loan;
use Illuminate\Database\Seeder;

class LoansSeeder extends Seeder
{
    public function run()
    {
        Loan::insert([
            [
                'start' => '2024-05-01',
                'end' => '2024-05-08',
                'price' => 105.00,
                'status' => 'zwrócone',
                'user_id' => 1,
            ],
            [
                'start' => '2024-05-03',
                'end' => '2024-05-10',
                'price' => 105.00,
                'status' => 'zwrócone',
                'user_id' => 2,
            ],
            [
                'start' => '2024-05-05',
                'end' => '2024-05-12',
                'price' => 70.00,
                'status' => 'zwrócone',
                'user_id' => 3,
            ],
            [
                'start' => '2024-05-07',
                'end' => '2024-05-14',
                'price' => 63.00,
                'status' => 'zwrócone',
                'user_id' => 4,
            ],
            [
                'start' => '2024-05-10',
                'end' => '2024-05-17',
                'price' => 84.00,
                'status' => 'zwrócone',
                'user_id' => 5,
            ],
            [
                'start' => '2024-05-12',
                'end' => '2024-05-19',
                'price' => 77.00,
                'status' => 'zwrócone',
                'user_id' => 6,
            ],
            [
                'start' => '2024-05-15',
                'end' => '2024-05-22',
                'price' => 91.00,
                'status' => 'zwrócone',
                'user_id' => 7,
            ],
            [
                'start' => '2024-05-18',
                'end' => '2024-05-25',
                'price' => 70.00,
                'status' => 'zwrócone',
                'user_id' => 8,
            ],
            [
                'start' => '2024-05-20',
                'end' => '2024-05-27',
                'price' => 98.00,
                'status' => 'zwrócone',
                'user_id' => 9,
            ],
            [
                'start' => '2024-05-22',
                'end' => '2024-05-29',
                'price' => 91.00,
                'status' => 'zwrócone',
                'user_id' => 10,
            ],
        ]);
    }
}
