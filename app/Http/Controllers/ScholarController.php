<?php

namespace App\Http\Controllers;

use App\Models\Scholar;
use App\Models\ScholarStatus;
use App\Models\ScholarProfile;
use Illuminate\Http\Request;
use App\Http\Requests\ScholarRequest;
use App\Http\Traits\DropdownTrait;
use App\Http\Traits\ScholarTrait;
use App\Http\Resources\ScholarResource;
use Hashids\Hashids;    

class ScholarController extends Controller
{
    use DropdownTrait, ScholarTrait;

    public function index(){
        $categories = $this->dropdown("Category","-");
        $statuses = $this->dropdown("Status","-");
        return view('user_coordinator.scholar')->with('categories',$categories)->with('statuses',$statuses);    
    }

    public function import(){
        return view('user_coordinator.scholar-batch');    
    }

    public function lists($status,$category,$count,$keyword){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Scholar::with('profile')
        ->whereHas('profile',function ($query) use ($keyword) {
            $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%');
        })
        ->where(function ($query) use ($category,$status) {
            ($category == '-') ? '' : $query->where('category_id',$category);
            ($status == '-') ? '' : $query->where('status_id',$status);
        })
        ->orderBy('id','DESC')->paginate($count);
        return ScholarResource::collection($data);
    }

    public function store(ScholarRequest $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable == "true"){
                $data = Scholar::findOrFail($request->id);
                $data->update($request->except('img','editable'));
                $profile = ScholarProfile::where('scholar_id',$request->id)->first();
                $profile->update($request->except('email','img','editable'));
                return $data;
            }else{
                $parents = [
                    'mother' => $request->mother,
                    'father' => $request->father,
                ];
                $information = [
                    'social' => $request->social,
                    'email' => $request->email,
                    'parents' => $parents,
                ];
                $data = Scholar::create($request->all());
                $data->profile()->create(array_merge($request->all(), ['information' => json_encode($information)]));
                $this->storeImage($request,$data->id);
                return $data;
            }
        });
        return new ScholarResource($data);
    }

    public function status(Request $request){
        $data = Scholar::findOrFail($request->id);
        $data->status_id = $request->status;
        if($data->save()){
            $status = new ScholarStatus;
            $status->status_id = $data->status_id;
            $status->scholar_id = $request->id;
            $status->updated_by = \Auth::user()->id;
            $status->save();
        }
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = Scholar::with('profile')->where('id',$id)->first();
        return new ScholarResource($data);
    }   
}
