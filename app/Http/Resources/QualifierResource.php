<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Hashids\Hashids;

class QualifierResource extends JsonResource
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
        $code = $hashids->encode($this->id);
        
        return [
            'id' => $this->id,
            'code' => $code,
            'applicant_id' => $this->applicant_id,
            'lrn' => ($this->lrn == null) ? 'n/a' : $this->lrn,
            'category_id' => $this->category,
            'year' => $this->year,
            'profile_id' => $this->profile->id,
            'avatar' => $this->profile->avatar,
            'firstname' => $this->profile->firstname,
            'lastname' => $this->profile->lastname,
            'middlename' => $this->profile->middlename,
            'suffix' => $this->profile->suffix,
            'gender' => $this->profile->gender,
            // 'gender' => ($this->profile->gender == 0) ? 'Female' : 'Male',
            'mobile' => $this->profile->mobile,
            'email' => $this->profile->email,
            'birthday' => $this->profile->birthday,
            'birth_place' => ucwords(strtolower($info->birth_place)),
            'course' => $info->course,
            'school' => $info->school,
            'barangay' => $info->address->barangay,
            'municipality' => $info->address->municipality,
            'province' => $info->address->province,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
