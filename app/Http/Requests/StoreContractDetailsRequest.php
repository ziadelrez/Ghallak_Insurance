<?php

namespace App\Http\Requests;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
class StoreContractDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('contract_details_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
            'carname' => 'required',
            'days' => 'required',
            'dateout' =>'required|date',
            'timeout' =>'required',
            'datein' =>'required|date',
            'timein' =>'required',
            'kmsout' =>'required',
            'kmsin' =>'required',
            'gas' =>'required',
            'gascost' =>'required',
//            'driver' =>'required',
            'drivercost' =>'required',
//            'officedatein' =>'required|date',
//            'officetimein' =>'required',
            'dayrate' =>'required',
//            'hcost' =>'required',
//            'extratime' =>'required',
//            'extracost' =>'required',
            'stotal' =>'required',
            'curr' =>'required',
            'deposit' =>'required',
            'depcurr' =>'required',
        ];
    }

    public function messages(){
        return [
            'carname.required'=>__('validation.carname_required'),
            'days.required'=>__('validation.days_required'),
            'dateout.required'=>__('validation.dateout_required'),
            'timeout.required'=>__('validation.timeout_required'),
            'datein.required|date'=>__('validation.datein_required'),
            'timein.required'=>__('validation.timein_required'),
            'kmsout.required'=>__('validation.kmsout_required'),
            'kmsin.required'=>__('validation.kmsin_required'),
            'gas.required'=>__('validation.gas_required'),
            'gascost.required'=>__('validation.gascost_required'),
            'driver.required'=>__('validation.driver_required'),
            'drivercost.required'=>__('validation.drivercost_required'),
//            'officedatein.required'=>__('validation.officedatein_required'),
//            'officetimein.required'=>__('validation.officetimein_required'),
            'dayrate.required'=>__('validation.dayrate_required'),
//            'hcost.required'=>__('validation.hcost_required'),
//            'extratime.required'=>__('validation.extratime_required'),
//            'extracost.required'=>__('validation.extracost_required'),
            'stotal.required'=>__('validation.stotal_required'),
            'curr.required'=>__('validation.curr_required'),
            'deposit.required'=>__('validation.deposit_required'),
            'depcurr.required'=>__('validation.depcurr_required'),
        ];
    }

}
