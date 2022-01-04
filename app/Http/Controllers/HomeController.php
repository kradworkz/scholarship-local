<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\ListExpense;
use Illuminate\Http\Request;
use App\Exports\EntryExport;
use App\Imports\ScholarImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Traits\DropdownTrait;
use App\Http\Resources\DefaultResource;

class HomeController extends Controller
{
    use DropdownTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        $benefits = $this->dropdown("Benefit Type","-");
        $categories = $this->dropdown("Category","-");
        $statuses = $this->dropdown("Status","-");
        return view('home')->with('categories',$categories)->with('statuses',$statuses)->with('benefits',$benefits);   
    }

    public function index()
    {   
        $role = \Auth::user()->role;
        if(Auth::user()->is_active == 0){
            return view('user_common.password');
        }else if($role == "Super Administrator"){
            return view('user_admin.index');    
        }else if($role == "Scholarship Coordinator"){
            return view('user_admin.index');    
        }else if($role == "Scholarship Staff"){
            return view('user_admin.index');    
        }else{
            return view('user_admin.index');    
        }
    }

    public function export(){
        return Excel::download(new EntryExport, 'users.xls');
        
    }

    public function import(Request $request){
        $data =  Excel::toCollection(new ScholarImport,$request->import_file);
        $rows = $data[0];

        foreach($rows as $row){
            if($row[0] != null){

                $parents = [
                    'mother' => $row[6],
                    'father' => $row[7],
                ];

                $information = [
                    'social' => 'n/a',
                    'parents' => $parents,
                ];

                $category = [
                    'id' => $row[13],
                    'name' => $row[10],
                ];
                $status = [
                    'id' => $row[14],
                    'name' => $row[11],
                ];

                $name[] = [
                    'lastname' => $row[0],
                    'firstname' => $row[1],
                    'middlename' => $row[2],
                    'suffix' => ($row[3] != null) ? $row[3] : 'n/a',
                    'gender' => $row[4],
                    'mobile' => $row[5],
                    'information' => $information,
                    'status' => $status,
                    'category' => $category
                ]; 
            }
        }
        return $name;
    }

    public function expenditures(){
        $data = $this->dropdown("Expenditure","-");
        return DefaultResource::collection($data);
    }

    public function expenses(){
        $data = ListExpense::all();
        return $data;
    }

}
