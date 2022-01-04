<?php

namespace App\Http\Traits;

use App\Models\ScholarProfile;

trait ScholarTrait {
    
    public function storeImage($request,$id){
        if($request->input('img') != ''){
            ($request->input('lastname') != '') ? $name = strtolower($request->input('lastname')).'-'.$id : $name = $id;
            $data = $request->input('img');
            $img = explode(',', $data);
            $ini =substr($img[0], 11);
            $type = explode(';', $ini);
            if($type[0] == 'png'){
                $image = str_replace('data:image/png;base64,', '', $data);
            }else{
                $image = str_replace('data:image/jpeg;base64,', '', $data);
            }
            $image = str_replace(' ', '+', $image);
            $imageName = $name.'.'.$type[0];
            
            if(\File::put(public_path('images/avatars'). '/' . $imageName, base64_decode($image))){
                $data = ScholarProfile::where('scholar_id',$id)->first();
                $data->avatar = $imageName;
                $data->save();
            }
        }
        return $data;
    }
}