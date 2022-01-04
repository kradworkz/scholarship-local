<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllotmentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        if($this->type == 'Allotment'){
            $rules = [
                'check_no' => 'required|string|max:100',
                'checked_at' => 'required',
                'credited_at' => 'required'
            ];
        }else{
            $rules = [
                'amount' => 'required',
                'expense_id' => 'required',
                'allotment_id' => 'required'
            ];
        }
        return $rules;
    }

    public function messages()
    {
        $message = [
            'check_no.required' => '* required',
            'checked_at.required' => '* required',
            'credited_at.required' => '* required',
            'amount' => '* required',
            'expense_id' => '* requried',
        ];

        return $message;
    }
}
