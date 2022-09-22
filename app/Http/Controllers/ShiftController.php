<?php

namespace App\Http\Controllers;

use App\Actions\insertShiftDataAction;
use App\Http\Requests\ScheduleShiftRequest;
use App\Http\Resources\ShiftResource;
use App\Models\Shift;
use App\Models\ShiftDuration;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Traits\insertShiftDataTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;

class ShiftController extends Controller
{
    use ApiResponseTrait;

    public function scheduleEmployeeShift(ScheduleShiftRequest $request)
    {
        if (User::where('id', $request->employee_id)->exists() == null) return $this->error('User did not exist', 422);

        $start_date = $request->start_date ?: null;
        $shift_days = $request->shift_days ?: 1;
        $verify_date_format = $this->verifyDateFormat($start_date);

        if ($verify_date_format == false) {
            return $this->error($verify_date_format['message'], 406);
        }

        return (new insertShiftDataAction())->insertShiftData($verify_date_format['start_date'], $request->employee_id, $shift_days);
    }

    private function verifyDateFormat(string $start_date = null)
    {
        $start_date = (is_null($start_date) ? Carbon::now()->format('Y-m-d') : date('Y-m-d', strtotime($start_date)));

        if (DateTime::createFromFormat('Y-m-d', $start_date) == false) {
            return ['status' => false, 'message' => 'Date format is wrong, expected format is E.g 2020-04-23'];
        }

        return ['status' => true, 'start_date' => $start_date];
    }

    public function fetchIndividualEmployeeShift(ScheduleShiftRequest $request)
    {
        if (User::where('id', $request->employee_id)->exists() == null) return $this->error('User did not exist', 422);

        $shift = Shift::latest('id')->where('employee_id', $request->employee_id)->paginate(100);

        if (empty($shift->items())) {
            return $this->error('', 401, 'This employee has no shift record(s)');
        }

        return  ShiftResource::collection($shift);
    }

    public function fetchEmployeeShift()
    {
        $shift =  Shift::latest('id')->paginate(100);

        if (empty($shift->items())) {
            return $this->error('', 401, 'This employee has no shift record(s)');
        }

        return  ShiftResource::collection($shift);
    }

    public function fetchEmployee()
    {
        $employee = User::where('status', 'employee')->paginate(10);

        if (empty($employee->items())) {
            return $this->error('', 401, 'No employee data in the database, you can seed using the /api/run-seeder route.');
        }

        return $this->success($employee, '', 200);
    }
}
