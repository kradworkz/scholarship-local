<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncQualifierRequest extends FormRequest
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
        return [
            'lrn' => 'sometime|required|string|unique:qualifiers,lrn,'.$this->id,
            'email' => 'sometimes|required|string|max:150|unique:users,email,'.$this->id,
            'firstname' => 'sometimes|required|string|max:100',
            'lastname' => 'sometimes|required|string|max:100',
            'middlename' => 'sometimes|required|string|max:100',
            'suffix' => 'sometimes|nullable|string|max:20',
            'gender' => 'sometimes|required',
            'mobile' => 'sometimes|required',
            'school_code' => 'sometimes|required',
            'applied_program' => 'sometimes|required',
        ];
    }
}
