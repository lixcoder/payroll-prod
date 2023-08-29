<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PayrollExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $total_pay;
    protected $total_earning;
    protected $total_gross;
    protected $total_paye;
    protected $total_nssf;
    protected $total_nhif;
    protected $total_others;
    protected $total_deds;
    protected $total_net;
    protected $data;
    protected $data_allowance;
    protected $data_nontax;
    protected $data_earnings;
    protected $data_overtime;
    protected $data_overtime_hourly;
    protected $data_overtime_daily;
    protected $data_relief;
    protected $data_deduction;
    protected $organization;
    protected $currency;
    protected $selBranch;
    protected $selDept;
    protected $period;
    protected $sels;
    protected $selBr;
    protected $selDt;

    public function __construct($total_pay, $total_earning, $total_gross, $total_paye, $total_nssf, $total_nhif, $total_others, $total_deds, $total_net, $data, $data_allowance, $data_nontax, $data_earnings, $data_overtime, $data_overtime_hourly, $data_overtime_daily, $data_relief, $data_deduction,$organization,$currency,$selBranch,$selDept,$period,$sels,$selBr,$selDt)
    {
        $this->total_pay = $total_pay;
        $this->total_earning = $total_earning;
        $this->total_gross = $total_gross;
        $this->total_paye = $total_paye;
        $this->total_nssf = $total_nssf;
        $this->total_nhif = $total_nhif;
        $this->total_others  = $total_others;
        $this->total_deds = $total_deds;
        $this->total_net = $total_net;
        $this->data = $data;
        $this->data_allowance =$data_allowance;
        $this->data_nontax = $data_nontax;
        $this->data_earnings = $data_earnings;
        $this->data_overtime  = $data_overtime;
        $this->data_overtime_hourly = $data_overtime_hourly;
        $this->data_overtime_daily = $data_overtime_daily;
        $this->data_relief = $data_relief;
        $this->data_deduction  = $data_deduction;
        $this->organization = $organization;
        $this->currency = $currency;
        $this->selBranch = $selBranch;
        $this->selDept = $selDept;
        $this->period = $period;
        $this->sels = $sels;
        $this->selBr = $selBr;
        $this->selDt = $selDt;

    }

    public function view(): view
    {
        return view('pdf.reports.summaryTable',[
            'total_pay'=>$this->total_pay,
            'total_earning'=>$this->total_earning,
            'total_gross'=>$this->total_gross,
            'total_paye'=>$this->total_paye,
            'total_nssf'=>$this->total_nssf,
            'total_nhif'=>$this->total_nhif,
            'total_others'=>$this->total_others,
            'total_deds'=>$this->total_deds,
            'total_net'=>$this->total_net,
            'data'=>$this->data,
            'data_allowance'=>$this->data_allowance,
            'data_nontax'=>$this->data_nontax,
            'data_earnings'=>$this->data_earnings,
            'data_overtime'=>$this->data_overtime,
            'data_overtime_hourly'=>$this->data_overtime_hourly,
            'data_overtime_daily'=>$this->data_overtime_daily,
            'data_relief'=>$this->data_relief,
            'data_deduction'=>$this->data_deduction,
            'organization'=>$this->organization,
            'currency'=>$this->currency,
            'selBranch'=>$this->selBranch,
            'selDept'=>$this->selDept,
            'period'=>$this->period,
            'sels'=>$this->sels,
            'selBr'=>$this->selBr,
            'selDt'=>$this->selDt,
        ]);
    }

}
