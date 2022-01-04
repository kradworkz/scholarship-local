<?php

namespace App\Http\Traits;
use App\Models\Dropdown;
use App\Http\Resources\DefaultResource;

trait DropdownTrait {
    public function dropdown($classification,$type) {
        $query = Dropdown::query();
        ($type != '-') ? $query->where('type',$type) : '';
        $data = $query->where('classification',$classification)->get();

        return DefaultResource::collection($data);
    }
}