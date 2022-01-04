<?php

namespace App\Http\Controllers\Lists;

use App\Models\ListExpense;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ExpenseController extends Controller
{
    public function index($keyword,$count){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = ListExpense::with('type')->orderBy('id','DESC')->paginate($count);
        return DefaultResource::collection($data);
    }

    public function lists(){
        $data = ListExpense::orderBy('id','DESC')->get();
        return DefaultResource::collection($data);
    }

    public function store(Request $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable){
                $data = ListExpense::with('type')->where('id',$request->id)->first();
                $data->update($request->except('editable'));
                return $data;
            }else{
                $data = ListExpense::create($request->all());
                $data = ListExpense::with('type')->where('id',$data->id)->first();
                return $data;
            }
        });
        return new DefaultResource($data);
    }
}
