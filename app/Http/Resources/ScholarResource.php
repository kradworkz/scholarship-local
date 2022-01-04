<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Hashids\Hashids;

class ScholarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $info =  json_decode($this->profile->information);
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);
        
        return [
            'id' => $this->id,
            'code' => $id,
            'lrn' => ($this->lrn == null) ? 'n/a' : $this->lrn,
            'spas' => ($this->spas == null) ? 'n/a' : $this->spas,
            'category_id' => $this->category,
            'applicant_id' => $this->applicant_id,
            'status_id' => $this->status,
            'awarded_year' => $this->awarded_year,
            'avatar' => $this->profile->avatar,
            'firstname' => $this->profile->firstname,
            'lastname' => $this->profile->lastname,
            'middlename' => $this->profile->middlename,
            'suffix' => $this->profile->suffix,
            'gender' => $this->profile->gender,
            'mobile' => $this->profile->mobile,
            // 'social' => $info->social,
            // 'father' => $info->parents->father,
            // 'mother' => $info->parents->mother,
            'birth_place' => ucwords(strtolower($info->birth_place)),
            'course' =>  $this->course, //$info->course, 
            'school' => $this->school,//$info->school,
            'barangay' => $this->address->address, //$info->address->barangay,
            'municipality' => $this->address->municipality, //$info->address->municipality,
            'province' => $this->address->province,  //$info->address->province,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
