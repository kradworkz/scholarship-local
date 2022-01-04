<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => ucwords(strtolower($this->school->name)),
            'campus' => ucwords(strtolower($this->campus)),
            'address' => ucwords(strtolower($this->address)),
            'municipality' => $this->municipality,
            'class' => $this->school->class,
            'term' => $this->school->term,
            'grading' => $this->school->grading,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
