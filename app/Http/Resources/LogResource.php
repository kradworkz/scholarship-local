<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    public function toArray($request)
    {
        $causer = $this->causer->profile->firstname.' '.$this->causer->profile->lastname;
        if($this->log_name == "user"){
            if($this->description == "created"){
                $subject = "Created user ".$this->subject->profile->firstname.' '.$this->subject->profile->lastname;
            }else{
                $subject = "Updated user ".$this->subject->firstname.' '.$this->subject->lastname;
            }
        }else if($this->log_name == "auth"){
            $subject = "login to the system";
        }

        return [
            'type' => $this->log_name,
            'description' => $this->description,
            'subject' => $subject,
            'causer' => $causer,
            'details' => $this->properties,
            'created_at' => $this->created_at,
        ];
    }
}
