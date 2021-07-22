<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccidentDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'accident_location' => 'required',
            'accident_date' => 'required|date',
            'accident_details' =>'required',
            'accident_cost' =>'required',
            'accident_curr' =>'required',
        ];
    }

    public function messages(){
        return [
            'accident_location.required'=>__('validation.accident_location_required'),
            'accident_date.required'=>__('validation.accident_date_required'),
            'accident_details.required'=>__('validation.accident_details_required'),
            'accident_cost.required'=>__('validation.accident_cost_required'),
            'accident_curr.required|date'=>__('validation.accident_curr_required'),
        ];
    }
}
