<?php

namespace App\Http\Controllers;

use App\Models\Allotment;
use App\Models\AllotmentList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\AllotmentResource;
use App\Http\Requests\AllotmentRequest;
use App\Http\Traits\AccountingTrait;
use Hashids\Hashids;  

class AllotmentController extends Controller
{
    use AccountingTrait;

    public function index($keyword,$count){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Allotment::orderBy('id','DESC')->paginate($count);
        return AllotmentResource::collection($data);
    }

    public function store(AllotmentRequest $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable){
                $data = Allotment::findOrFail($request->id);
                $data->update($request->except('editable'));
                return $data;
            }else{
                $code = $this->allotment();
                $data = Allotment::create(array_merge($request->all(),['code' => $code, 'added_by' => \Auth::user()->id]));
                return $data;
            }
        });
        return new AllotmentResource($data);
    }

    public function view($id){
        $hashids = new Hashids('wew',10);
        $id = $hashids->decode($id);
        $data = Allotment::with('lists','lists.expense','lists.user.profile')->where('id',$id[0])->first();
        return new AllotmentResource($data);
    }

    public function storeList(AllotmentRequest $request){
        $data = \DB::transaction(function () use ($request){
            $hashids = new Hashids('wew',10);
            $id = $hashids->decode($request->allotment_id);
            if($request->editable){
                $data = AllotmentList::with('expense','user.profile')->where('id',$request->id)->first();
                $data->update($request->except('editable','allotment_id'));
                return $data;
            }else{
                $data = AllotmentList::create(array_merge($request->all(),['allotment_id' => $id[0],'added_by' => \Auth::user()->id]));
                $data = AllotmentList::with('expense','user.profile')->where('id',$data->id)->first();
                return $data;
            }
        });
        return new DefaultResource($data);
    }
}
