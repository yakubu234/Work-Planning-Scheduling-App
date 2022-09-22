<?php

namespace App\Actions;

use App\Http\Resources\ShiftResource;
use App\Models\Shift;
use App\Models\ShiftDuration;
use Carbon\Carbon;
use App\Traits\ApiResponseTrait;

class insertShiftDataAction
{
    use ApiResponseTrait;

    private function fetchShiftPeriods()
    {
        $shiftDuration = ShiftDuration::all();

        if ($shiftDuration->isEmpty()) {
            return ['status' => false, 'message' => "error, no shift periods in database, you can seed using the /api/run-seeder route. "];
        }

        return  ['status' => true, 'data' => $shiftDuration];
    }

    public function insertShiftData(string $start_date, int $employee_id, int $shift_days)
    {
        $shiftPeriods = $this->fetchShiftPeriods();
        if ($shiftPeriods['status'] == false) return $this->error($shiftPeriods['message'], 400);

        $shiftPeriods = $shiftPeriods['data']->toArray();
        $shifts = [];

        for ($i = 0; $i < $shift_days; $i++) {

            $start_date = ($i == 0) ? $start_date : Carbon::parse($start_date)->addDay()->format('Y-m-d');

            $random =  array_rand($shiftPeriods, 1);

            if (Shift::where(['employee_id' => $employee_id, 'shift_date' => $start_date])->exists()) continue;

            $shifts[] = [
                'employee_id' => $employee_id,
                'shift_date' => $start_date,
                'start_time' => $shiftPeriods[$random]['start_time'],
                'end_time' => $shiftPeriods[$random]['end_time'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        if (!$shifts) return $this->error('Shift Schedule(s) already exist', 400);
        return $this->save($shifts);
    }

    private function save(array $shifts)
    {
        $num = count($shifts) + 1;
        $shift = Shift::insert($shifts);

        $shift = Shift::latest('id')->where('employee_id', $shifts[0]['employee_id'])->paginate($num);
        $data = ShiftResource::collection($shift)->response()->getData(true);
        return $this->success($data, "{ $num } Shift has been scheduled successfully ", 200);
    }
}
