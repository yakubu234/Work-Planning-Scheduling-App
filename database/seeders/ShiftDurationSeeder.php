<?php

namespace Database\Seeders;

use App\Models\ShiftDuration;
use Illuminate\Database\Seeder;
use App\Traits\ApiResponseTrait;

class ShiftDurationSeeder extends Seeder
{
    use ApiResponseTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['start_time' => '0:00', 'end_time' => '8:00'],
            ['start_time' => '8:00', 'end_time' => '16:00'],
            ['start_time' => '16:00', 'end_time' => '24:00'],
        ];

        try {
            ShiftDuration::insert($data);
        } catch (\Throwable $th) {

            if ($th->getCode() == 23000) {
                echo "you cannot seed duplicate shifts\n";
                return;
            }
        }

        echo "shift duration seeded\n";
        return;
    }
}
