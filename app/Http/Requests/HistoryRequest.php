<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryRequest extends FormRequest
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
        if($this->type == "History"){
            $rules = [
                'user' => 'required',
                'company' => 'required|string',
                'address' => 'required|string',
                'position' => 'required|string',
                'period' => 'required|string',
                'job' => 'required'
            ];
        }else if($this->type == "Award"){
            $rules = [
                'user' => 'required',
                'award' => 'required|string',
                'body' => 'required|string',
                'given' => 'required|string'
            ];
        }else if($this->type == "Research"){
            $rules = [
                'user' => 'required',
                'research' => 'required|string',
                'fund' => 'required|string',
                'duration' => 'required|string',
                'involvement' => 'required|string',
                'location' => 'required|string'
            ];
        }else if($this->type == "Affliation"){
            $rules = [
                'user' => 'required',
                'organization' => 'required|string',
                'position' => 'required|string',
                'duration' => 'required|string',
                'address' => 'required|string'
            ];
        }else{
           
        }



        return $rules;
    }
}
