<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class P10FormExports implements FromView
{
    protected $year;
    protected $employees;
    protected $organization;

    public function __construct($year, $employees, $organization)
    {
        $this->year = $year;
        $this->employees = $employees;
        $this->organization = $organization;
    }

    public function view(): View
    {
        return view('exports.p10Excel', [
            'year' => $this->year,
            'employees' => $this->employees,
            'organization' => $this->organization
        ]);
    }
}
