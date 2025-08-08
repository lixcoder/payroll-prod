<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OvertimesReportExport implements FromCollection, WithEvents, WithCustomStartCell
{
    protected $data;
    protected $total;
    protected $currency;
    protected $organization;
    protected $period;

    public function __construct($data, $total, $currency, $organization, $period)
    {
        $this->data = $data;
        $this->total = $total;
        $this->currency = $currency;
        $this->organization = $organization;
        $this->period = $period;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($item) {
            $name = $item->middle_name
                ? "{$item->first_name} {$item->middle_name} {$item->last_name}"
                : "{$item->first_name} {$item->last_name}";

            return [
                $item->personal_file_number,
                $name,
                $item->overtime_type,
                $item->overtime_amount
            ];
        });
    }

    public function startCell(): string
    {
        return 'A9';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = count($this->data) + 9;

                // Set metadata headers
                $sheet->setCellValue('A1', 'Organization Name:');
                $sheet->setCellValue('B1', $this->organization->name);

                $sheet->setCellValue('A2', 'Report name:');
                $sheet->setCellValue('B2', 'Overtime Report');

                $sheet->setCellValue('A3', 'Currency:');
                $sheet->setCellValue('B3', $this->currency->shortname);

                $sheet->setCellValue('A4', 'Period:');
                $sheet->setCellValue('B4', $this->period);

                // Set title
                $sheet->mergeCells('A6:D6');
                $sheet->setCellValue('A6', 'Overtime Report');

                // Set column headers
                $sheet->setCellValue('A8', 'PERSONAL FILE NUMBER');
                $sheet->setCellValue('B8', 'EMPLOYEE NAME');
                $sheet->setCellValue('C8', 'OVERTIME TYPE');
                $sheet->setCellValue('D8', 'AMOUNT');

                // Set total row
                $sheet->setCellValue("C{$lastRow}", 'Total');
                $sheet->setCellValue("D{$lastRow}", $this->total);

                // ======= APPLY STYLES ======= //
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ]
                ];

                // Apply bold to metadata labels
                $sheet->getStyle('A1:A4')->applyFromArray($styleArray);

                // Center title
                $sheet->getStyle('A6')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ]
                ]);

                // Column headers styling
                $sheet->getStyle('A8:D8')->applyFromArray($styleArray);

                // Amount column right alignment
                $sheet->getStyle('D9:D' . ($lastRow - 1))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ]
                ]);

                // Total row styling
                $sheet->getStyle("A{$lastRow}:D{$lastRow}")->applyFromArray($styleArray);
                $sheet->getStyle("D{$lastRow}")->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ]
                ]);

                // Auto-size columns
                foreach (range('A', 'D') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }
}
