<?php

namespace App\Http\Requests;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('clients_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
            'cname' => 'required|max:500',
            'moname' => 'required|max:200',
            'cadr' =>'required',
            'creg' =>'required',
            'cctype' =>'required',
            'natio' =>'required',
            'cmob' =>'required',
            'sigil' =>'required',
            'place' =>'required',
            'birthdate' =>'required|date',
//            'passnum' =>'unique:clients,passnum',
            'passplace' =>'required',
            'passdate' =>'required|date',
        ];
    }

    public function messages(){
        return [
            'cname.required' => __('validation.cname_required'),
//            'cname.unique' => __('validation.cname_unique'),
            'moname.required' => __('validation.moname_required'),
            'cadr.required' =>__('validation.cadr_required'),
            'creg.required' =>__('validation.creg_required'),
            'cctype.required' =>__('validation.cctype_required'),
            'natio.required' =>__('validation.natio_required'),
            'cmob.required' =>__('validation.cmob_required'),
            'sigil.required' =>__('validation.sigil_required'),
            'place.required' =>__('validation.place_required'),
            'birthdate.required' =>__('validation.birthdate_required'),
//            'passnum.required' =>__('validation.passnum_required'),
//            'passnum.unique' =>__('validation.passnum_unique'),
            'passplace.required' =>__('validation.passplace_required'),
            'passdate.required' =>__('validation.passdate_required'),
        ];
    }
}
