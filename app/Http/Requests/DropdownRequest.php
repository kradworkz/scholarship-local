<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DropdownRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:100|unique:dropdowns,name,NULL,'.$this->id.',classification,'.$this->classification,
            'classification' => 'required|string|max:30',
        ];

        
        if($this->classification == 'Group' && $this->classification == 'Salary'){
            $rules = array_merge($rules, ['type' => 'required|string|max:30']);
        }else if($this->selected == 'Asset'){
            $rules = array_merge($rules, ['color' => 'required|unique:dropdowns,color,NULL,'.$this->id.',type,'.$this->type]);
        }else{
        }
        
        
        return $rules;
    }
}
