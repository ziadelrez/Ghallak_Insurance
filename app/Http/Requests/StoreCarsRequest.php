<?php

namespace App\Http\Requests;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreCarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('cars_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'carname' => 'required|max:500',
            'platnumber' => 'required|max:200',
            'cartype' =>'required',
            'carmodel' =>'required',
            'carcolor' =>'required',
            'carrate' =>'required',
            'curr' =>'required',
            'carsspecs' =>'required',
            'carused' =>'required|date',
            'photo' =>'required',
            'passenger' =>'required',
            'bags' =>'required',
            'doors' =>'required',
            'transmission' =>'required',
            'carenginetype' =>'required',
            'branch' =>'required',
        ];
    }

    public function messages(){
        return [
            'carname.required' => __('validation.carname_required'),
            'platnumber.required' => __('validation.platnumber_required'),
            'platnumber.unique' => __('validation.platnumber_unique'),
            'cartype.required' =>__('validation.cartype_required'),
            'carmodel.required' =>__('validation.carmodel_required'),
            'carcolor.required' =>__('validation.carcolor_required'),
            'carrate.required' =>__('validation.carrate_required'),
            'curr.required' =>__('validation.curr_required'),
            'carsspecs.required' =>__('validation.carspecs_required'),
            'carused.required' =>__('validation.carused_required'),
            'photo.required' =>__('validation.photo_required'),
            'carenginetype.required' =>__('validation.carenginetype_required'),
            'passenger.required' =>__('validation.passenger_required'),
            'bags.required' =>__('validation.bags_required'),
            'doors.required' =>__('validation.doors_required'),
            'transmission.required' =>__('validation.transmission_required'),
            'branch.required' =>__('validation.branch_required'),
        ];
    }
}
