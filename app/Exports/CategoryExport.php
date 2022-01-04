<?php

namespace App\Exports;

use App\Models\Dropdown;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Http\Resources\DefaultResource;
use Maatwebsite\Excel\Concerns\WithEvents;

class CategoryExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    public function collection()
    {
        $data = Dropdown::select('name','id')->where('classification','Category')->get();
        return DefaultResource::collection($data);
    }

    public function headings(): array
    {
        return ["name","id"];
    }

    public function title(): string
    {
        return 'Categories';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
               
                $event->sheet->getProtection()->setPassword('password');
                $event->sheet->getProtection()->setSheet(true);
               
            }
        ];
    }
}
