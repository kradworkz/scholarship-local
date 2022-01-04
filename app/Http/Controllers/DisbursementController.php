<?php

namespace App\Http\Controllers;

use App\Models\Disbursement;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DisbursementResource;
use App\Http\Requests\DisbursementRequest;
use Hashids\Hashids;

class DisbursementController extends Controller
{
    public function index($keyword,$count){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Disbursement::with('expense')->with('user.profile')->orderBy('id','DESC')->paginate($count);
        return DisbursementResource::collection($data);
    }

    public function store(DisbursementRequest $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable){
                $data = Disbursement::findOrFail($request->id);
                $data->update($request->except('editable'));
                return $data;
            }else{
                $data = Disbursement::create(array_merge($request->all(),['added_by' => \Auth::user()->id]));
                $data = Disbursement::with('expense')->where('id',$data->id)->first();
                return $data;
            }
        });
        return new DisbursementResource($data);
    }
}
