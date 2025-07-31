<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class RemittanceReportExport implements FromArray, WithTitle, WithEvents
{
    protected $data;
    protected $total;
    protected $mont;
    protected $organization;
    protected $currency;
    protected $branch;
    protected $bank;

    public function __construct($data, $total, $mont, $organization, $currency, $branch, $bank)
    {
        $this->data = $data;
        $this->total = $total;
        $this->mont = $mont;
        $this->organization = $organization;
        $this->currency = $currency;
        $this->branch = $branch;
        $this->bank = $bank;
    }

    public function array(): array
    {
        $rows = [];

        // Title row
        $rows[] = [$this->organization->name];

        // Header row
        $rows[] = [
            'STAFF NO.',
            'EMPLOYEE NAME',
            'CODE',
            'ACCOUNT NO.',
            'AMOUNT',
            'PAY MTHD',
            'DR AC',
            '',
            'MONTH',
            'CURRENCY',
            '',
            'SHA',
            ''
        ];

        // Data rows
        foreach ($this->data as $item) {
            $name = $item->middle_name
                ? $item->first_name . ' ' . $item->middle_name . ' ' . $item->last_name
                : $item->first_name . ' ' . $item->last_name;

            $rows[] = [
                $item->personal_file_number,
                $name,
                $item->bank_eft_code,
                $item->bank_account_number,
                $item->net,
                'corporate salary transfer',
                $this->organization->bank_account_number,
                '',
                $this->mont,
                $this->currency->shortname,
                '',
                'SHA',
                ''
            ];
        }

        // Total row
        $rows[] = ['', '', '', 'Total', $this->total];

        return $rows;
    }

    public function title(): string
    {
        return 'Remittance Report';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Set page orientation
                $event->sheet->getDelegate()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                // Merge title cells
                $event->sheet->mergeCells('A1:M1');

                // Set title style
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
                ]);

                // Set header row style
                $event->sheet->getDelegate()->getStyle('A2:M2')->applyFromArray([
                    'font' => ['bold' => true]
                ]);

                // Set column widths
                $widths = [
                    'A' => 15,
                    'B' => 35,
                    'C' => 15,
                    'D' => 20,
                    'E' => 15,
                    'F' => 30,
                    'G' => 20,
                    'H' => 10,
                    'I' => 15,
                    'J' => 15,
                    'K' => 10,
                    'L' => 15,
                    'M' => 10
                ];

                foreach ($widths as $column => $width) {
                    $event->sheet->getDelegate()
                        ->getColumnDimension($column)
                        ->setWidth($width);
                }

                // Set amount formatting
                $lastRow = count($this->data) + 4; // Header + Title + Data + Total
                $amountColumn = 'E';
                $event->sheet->getDelegate()
                    ->getStyle("{$amountColumn}3:{$amountColumn}{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                // Align total amount
                $event->sheet->getDelegate()
                    ->getStyle("E{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // Set data alignment
                $event->sheet->getDelegate()
                    ->getStyle('A3:M' . ($lastRow - 1))
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Set total row style
                $event->sheet->getDelegate()->getStyle("A{$lastRow}:M{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true]
                ]);
            }
        ];
    }
}
