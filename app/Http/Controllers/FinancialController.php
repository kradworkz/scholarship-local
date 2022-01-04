<?php

namespace App\Http\Controllers;

use App\Models\Scholar;
use App\Models\ScholarFinancial;
use App\Models\ScholarFinancialList;
use Illuminate\Http\Request;
use Hashids\Hashids; 
use App\Http\Traits\FinancialTrait;
use App\Http\Traits\DropdownTrait;
use App\Http\Resources\DefaultResource;
use App\Http\Requests\FinancialRequest;

class FinancialController extends Controller
{
    use FinancialTrait,DropdownTrait;

    public function index($id,$count){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = ScholarFinancial::with('lists','lists.benefit')->where('scholar_id',$id)->orderBy('created_at','DESC')->paginate($count);
        return DefaultResource::collection($data);
    }   

    public function store(FinancialRequest $request){
        \DB::transaction(function () use ($request){
            $hashids = new Hashids('krad',10);
            $id = $hashids->decode($request->user);

            $test = [];
            $data = new ScholarFinancial;
            $data->release_type = $request->release;
            $data->session_type = $request->type;
            $data->academic_year = $request->ay;
            $data->total = 1;
            $data->attachment = json_encode($test);
            $data->scholar_id = $id[0];
            $data->added_by = \Auth::user()->id;

            if($data->save()){
                $lists = $request->lists;
                foreach($lists as $key=>$list){
                    // dd($list['benefit']['id']);
                    if($list['benefit']['name'] == 'Stipend'){
                        $amounts = $list['amount'];
                        $flags = $list['flag'];
                        $total = 0;
                        foreach($amounts as $key=>$amount){
                            // dd($benefit['val']);
                            $b = new ScholarFinancialList;
                            $b->benefit_id = $list['benefit']['id'];
                            $b->financial_id = $data->id;
                            $b->flag = $flags[$key]['val']['id'];
                            $b->type =  $list['benefit']['type'];
                            $b->amount = $amount['val'];
                            $b->save();
                            
                            $total = $total + $amount['val'];
                        }
                    }else{
                        $amounts = $lists[$key]['amount'];
                        $flags = $lists[$key]['flag'];
                        $b = new ScholarFinancialList;
                        $b->benefit_id = $list['benefit']['id'];
                        $b->financial_id = $data->id;
                        $b->flag = $flags;
                        $b->type =  $list['benefit']['type'];
                        $b->amount = $amounts[0]['val'];
                        $b->save();
                        
                        $total = $total + $amount['val'];
                    }
                }

                $data->total = $total;
                $data->save();
            }
        });
    }

    public function stipend($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = ScholarFinancialList::where('benefit_id',17)
        ->whereHas('financial',function ($query) use ($id){
            $query->where('academic_year','2020-2021')->where('scholar_id',$id);
        })->get()->toArray();

        $stipends = [];
        for($i = 1; $i <= 12; $i++){
            $m = date('F', mktime(0, 0, 0, $i, 10));
            $key=array_search($m,array_column($data, 'flag'));
            if($key !== false){
                $stipends[] = [
                    'month' => $m,
                    'amount' => $data[$key]['amount'],
                    'date' => $data[$key]['created_at'],
                ];
            }else{
                $stipends[] = [
                    'month' => $m,
                    'amount' => '<i class="text-danger bx bx-x"></i>',
                    'date' => '<i class="text-danger bx bx-x"></i>',
                ];
            }
        }
        
        return $stipends;
    }

    public function breakdown($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $benefits = $this->dropdown("Benefit Type","-");
        $arr = [];

        $ay = Scholar::select('awarded_year')->where('id',$id)->first();
        $ay = $ay['awarded_year'];

        foreach($benefits as $key=>$benefit){

            $lists = [
                1 => [
                    'selectable' => ($benefit->type != "One-time") ? 'unselectable' : '',
                    'data' =>($benefit->type != "One-time") ? '' : $this->check($id,$benefit->id,null,null),
                ],
                2 => [
                    'selectable' => ($benefit->type != "Term") ? 'unselectable' : '',
                    'data' => ($benefit->type != "Term") ? '' :  $this->check($id,$benefit->id,'1st term',null),
                ],
                3 => [
                    'selectable' => ($benefit->type != "Term") ? 'unselectable' : '',
                    'data' => ($benefit->type != "Term") ? '' :  $this->check($id,$benefit->id,'2nd term',null),
                ],
                4 => [
                    'selectable' => ($benefit->type != "Term") ? 'unselectable' : '',
                    'data' => ($benefit->type != "Term") ? '' :  $this->check($id,$benefit->id,'3rd term',null),
                ],
                5 => [
                    'selectable' => ($benefit->type != "Academic Year") ? 'unselectable' : '',
                    'data' => ($benefit->type != "Academic Year") ? '' :  $this->check($id,$benefit->id,null,$ay.'-'.($ay+1)),
                ],
                6 => [
                    'selectable' => ($benefit->type != "Academic Year") ? 'unselectable' : '',
                    'data' => ($benefit->type != "Academic Year") ? '' :  $this->check($id,$benefit->id,null,($ay+1).'-'.($ay+2)),
                ],
                7 => [
                    'selectable' => ($benefit->type != "Academic Year") ? 'unselectable' : '',
                    'data' => ($benefit->type != "Academic Year") ? '' :  $this->check($id,$benefit->id,null,($ay+2).'-'.($ay+3)),
                ],
                8 => [
                    'selectable' => ($benefit->type != "Academic Year") ? 'unselectable' : '',
                    'data' =>($benefit->type != "Academic Year") ? '' :  $this->check($id,$benefit->id,null,($ay+3).'-'.($ay+4)),
                ],
            ];

            
            if($key != 0){
                $arr[] = [
                    'name' => $benefit->name,
                    'type' => $benefit->type,
                    'lists' => $lists
                ];
            }

        }

        return $arr;
        // $onetime = $this->types($id,'One-time');
        // $term = $this->types($id,'Term');
        // $ay = $this->types($id,'Academic Year');

        // $wew = [
        //     'onetime' => $onetime,
        //     'term' => $term,
        //     'ay' => $ay
        // ];

        // return $wew;
    }

    public function types($id,$type){
        $data = ScholarFinancialList::with()->where('type',$type)
        ->whereHas('financial',function ($query){
            $query->where('scholar_id',3);
        })->get();

        return $data;
    }


}
