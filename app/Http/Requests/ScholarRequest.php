<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScholarRequest extends FormRequest
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
            'email' => 'sometimes|required|string|max:150|unique:users,email,'.$this->id,
            'firstname' => 'sometimes|required|string|max:100',
            'lastname' => 'sometimes|required|string|max:100',
            'middlename' => 'sometimes|required|string|max:100',
            'father' => 'sometimes|required|string|max:100',
            'mother' => 'sometimes|required|string|max:100',
            'suffix' => 'sometimes|nullable|string|max:20',
            'gender' => 'sometimes|required',
            'mobile' => 'sometimes|required', //unique:user_profiles,mobile,'.$this->id
            'img' => 'nullable|image64:jpeg,jpg,png',
            'category_id' => 'sometimes|required',
            'status_id' => 'sometimes|required',
            'awarded_year' => 'sometimes|required',
            'lnr' => 'nullable|string',
            'spas' => 'nullable|string',
        ];
    }
}
