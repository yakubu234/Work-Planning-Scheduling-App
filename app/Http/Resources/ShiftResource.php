<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'employee_id' => $this->employee_id,
            'employee_fullname' => $this->user->name,
            'employee-email' => $this->user->email,
            'shift_id' => $this->id,
            'shift_date' => $this->shift_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->user->status,
            'created_at' => $this->created_at,
        ];
    }
}
