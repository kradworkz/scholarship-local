<?php

namespace App\Exports;

use App\Models\Scholar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Http\Resources\ExportResource;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\ Excel\ Facades\ Excel;

class ScholarExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithEvents
{
    public $rowCount = 0;
    public function collection()
    {
        // $data = Scholar::with('profile')->get();
        $data = []; // return empty for data entry
        return ExportResource::collection($data);
    }

    public function headings(): array
    {
        return [
            "Lastname","Firstname","Middlename","Suffix","Gender","Mobile","Mother","Father", //a-h
            "LRN (Learner’s Reference Number)","SPAS ID No.","Category","Status","Year Awarded", //i-m
            "s_id","c_id" //n-o
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => [
                    'font' => ['bold' => true], 
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                    'fill' =>[
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'FF87CEEB'],
                    ],
                    'sizeAutoSize' => true
                ],
        ];
    }

    public function title(): string
    {
        return 'Scholars';
    }

    public function registerEvents(): array
    {

        //$event = $this->getEvent();
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->rowHeight(1, 25);
                $event->sheet->verticalAlign('A1:M1', 'center');
                $event->sheet->columnWidth('A', 25);
                $event->sheet->columnWidth('B', 25);
                $event->sheet->columnWidth('C', 25);
                $event->sheet->columnWidth('D', 10);
                $event->sheet->columnWidth('E', 10);
                $event->sheet->columnWidth('F', 15);
                $event->sheet->columnWidth('G', 20);
                $event->sheet->columnWidth('H', 20);
                $event->sheet->columnWidth('I', 25);
                $event->sheet->columnWidth('J', 25);
                $event->sheet->columnWidth('K', 20);
                $event->sheet->columnWidth('L', 20);
                $event->sheet->columnWidth('M', 17);

             
                $spreadsheet = $event->sheet;
                
                $validation = $spreadsheet->getCell('K2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST );
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.');
                $validation->setFormula1('\'Categories\'!$A$2:$A$9');
                $spreadsheet->setCellValue("N2", '=VLOOKUP(K2,Categories!$A$2:$B$9,2,0)');

                $row_count = 100;
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("K{$i}")->setDataValidation(clone $validation);
                    $spreadsheet->setCellValue("N{$i}", '=VLOOKUP(K'.$i.',Categories!$A$2:$B$9,2,0)');
                }


                $spreadsheet = $event->sheet;
                $validation = $spreadsheet->getCell('L2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST );
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.');
                $validation->setFormula1('\'Statuses\'!$A$2:$A$9');
                $spreadsheet->setCellValue("O2", '=VLOOKUP(L2,Statuses!$A$2:$B$9,2,0)');
                
                $row_count = 100;
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("L{$i}")->setDataValidation(clone $validation);
                    $spreadsheet->setCellValue("O{$i}", '=VLOOKUP(L'.$i.',Statuses!$A$2:$B$9,2,0)');
                }

                $validation1 = $spreadsheet->getCell('E2')->getDataValidation();
                $validation1->setType(DataValidation::TYPE_LIST );
                $validation1->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation1->setAllowBlank(false);
                $validation1->setShowInputMessage(true);
                $validation1->setShowErrorMessage(true);
                $validation1->setShowDropDown(true);
                $validation1->setErrorTitle('Input error');
                $validation1->setError('Value is not in list.');
                $validation1->setPromptTitle('Pick from list');
                $validation1->setPrompt('Please pick a value from the drop-down list.');
                $validation1->setFormula1('"Female,Male"');

                $row_count = 100;
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("E{$i}")->setDataValidation(clone $validation1);
                }

                $spreadsheet->getDelegate()->getHighestRow();
                $spreadsheet->getColumnDimension('N')->setVisible(false);
                $spreadsheet->getColumnDimension('O')->setVisible(false);
   
                // $event->sheet->getProtection()->setPassword('password');
                // $event->sheet->getProtection()->setSheet(true);
                // $event->sheet->getStyle('A1:J100')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            

                $event->sheet->getStyle('A1:H1')->applyFromArray(array(
                    'font' => array(
                        'size'      =>  10,
                        'bold'      =>  true
                    )
                ));
                $event->sheet->getStyle('J1:M1')->applyFromArray(array(
                    'font' => array(
                        'size'      =>  10,
                        'bold'      =>  true
                    )
                ));

                $event->sheet->getStyle('I1')->applyFromArray(array(
                    'font' => array(
                        'size'      =>  8,
                        'bold'      =>  true
                    )
                ));

                $event->sheet->getStyle('A1:H1')->applyFromArray(array(
                    'fill' => array(
                        'color' => array('rgb' => 'B0DDFF')
                    )
                ));

                $event->sheet->getStyle('I1:M1')->applyFromArray(array(
                    'fill' => array(
                        'color' => array('rgb' => '64F0AA')
                    )
                ));

                
            
            }
        ];
    }

   
}
