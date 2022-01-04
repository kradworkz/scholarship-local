<?php

namespace App\Exports;

use App\Exports\ScholarExport;
use App\Exports\CategoryExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EntryExport implements  WithMultipleSheets
{
  
    public function sheets(): array
    {
        return [
            'Scholars' => new ScholarExport(),
            'Categories' => new CategoryExport(),
            'Statuses' => new StatusExport()
        ];
    }
}
