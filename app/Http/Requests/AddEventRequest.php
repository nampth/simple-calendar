<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEventRequest extends FormRequest
{ 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'note' => 'required',
        ];
    }
}
