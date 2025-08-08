<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Border;

class EarningsReportExport implements FromCollection, WithEvents, WithCustomStartCell
{
    protected $data;
    protected $total;
    protected $type;
    protected $currency;
    protected $organization;
    protected $period;

    public function __construct($data, $total, $type, $currency, $organization, $period)
    {
        $this->data = $data;
        $this->total = $total;
        $this->type = $type;
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
                $item->earning_amount
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
                $sheet->setCellValue('B2', 'Earnings Report');

                $sheet->setCellValue('A3', 'Currency:');
                $sheet->setCellValue('B3', $this->currency->shortname);

                $sheet->setCellValue('A4', 'Period:');
                $sheet->setCellValue('B4', $this->period);

                // Set title
                $sheet->mergeCells('A6:C6');
                $sheet->setCellValue('A6', 'Earning Report for ' . $this->type);

                // Set column headers
                $sheet->setCellValue('A8', 'PERSONAL FILE NUMBER');
                $sheet->setCellValue('B8', 'EMPLOYEE NAME');
                $sheet->setCellValue('C8', 'AMOUNT');

                // Set total row
                $sheet->setCellValue("B{$lastRow}", 'Total');
                $sheet->setCellValue("C{$lastRow}", $this->total);

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
                $sheet->getStyle('A8:C8')->applyFromArray($styleArray);

                // Amount column right alignment
                $sheet->getStyle('C9:C' . ($lastRow - 1))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ]
                ]);

                // Total row styling
                $sheet->getStyle("A{$lastRow}:C{$lastRow}")->applyFromArray($styleArray);
                $sheet->getStyle("C{$lastRow}")->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ]
                ]);

                // Auto-size columns
                foreach (range('A', 'C') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }
}
