<?php

namespace App\Imports;

use App\Models\Scholar;
use App\Models\ScholarProfile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class ScholarImport implements WithCalculatedFormulas, WithValidation, WithStartRow, ToCollection
{
    public function collection(Collection $row)
    {
        // Scholar::create([
        //     'category_id' => 1,
        //     'status_id' => 2,
        //     'awarded_year' => "1990"
        // ]);
        // return $row;

        // foreach($rows as $row){
        //     $data = Scholar::create([
        //         'lnr' => $row[0][8],
        //         'spas' => $row[0][9],
        //         'category_id' => $row[0][14],
        //         'status_id' => $row[0][13],
        //         'awarded_year' => $row[0][12],
        //     ]);
        // }
        // $rowIndex = $row->getIndex();
        // $row      = $row->toArray();
        
        // if($row[0][0] != null){ 
        //     $data = Scholar::firstOrCreate([
        //         'lnr' => $row[0][8],
        //         'spas' => $row[0][9],
        //         'category_id' => $row[0][14],
        //         'status_id' => $row[0][13],
        //         'awarded_year' => $row[0][12],
        //     ]);
        
        //     $parents = [
        //         'mother' => $row[0][6],
        //         'father' => $row[0][7],
        //     ];

        //     $information = [
        //         'social' => 'n/a',
        //         'parents' => $parents,
        //     ];

        //     $data->profile()->create([
        //         'lastname' => $row[0][0],
        //         'firstname' => $row[0][1],
        //         'middlename' => $row[0][2],
        //         'suffix' => $row[0][3],
        //         'gender' => $row[0][4],
        //         'mobile' => $row[0][5],
        //         'information' => $information
        //     ]);
        // }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|string',
            '1' => 'required|string',
            '2' => 'required|numeric'
        ];
    }
}
