<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,uid'],
            'event_name' => ['required', 'string'],
            'location' => ['required', 'string'],
            'event_date' => ['required', 'date_format:Y-m-d'],
            'status' => ['in:active,inactive'],
            'type' => ['in:free,paid'],
        ];
    }
}
