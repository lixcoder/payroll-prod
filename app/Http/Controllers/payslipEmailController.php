<?php namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Organization;
use App\Models\Transact;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class payslipEmailController extends Controller
{

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        for ($i = 0; $i < 12; $i++) {
            $months[] = date("m-Y", strtotime(date('Y-m-01') . " -$i months"));
            $monthss1 = Transact::where('organization_id',Auth::user()->organization_id)->where('financial_month_year',$months[$i])->sum('basic_pay');
        }
        $employees = Employee::where('organization_id', Auth::user()->organization_id)->get();
        $payslips = Transact::where('organization_id', Auth::user()->organization_id)
            ->select('financial_month_year')
            ->groupBy('financial_month_year')
            ->get();
        return View::make('payslips.index', compact('employees','payslips'));
    }

    public function sendEmail()
    {
        if (!empty(request()->input('sel'))) {
            $period = request()->input('period');
            $employees = Employee::where('organization_id', Auth::user()->organization_id)->get();

            $emps = DB::table('x_employee')->count();
            foreach ($employees as $user) {

                $transacts = DB::table('x_transact')
                    ->join('x_employee', 'x_transact.employee_id', '=', 'x_employee.personal_file_number')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_transact.organization_id', Auth::user()->organization_id)
                    ->where('x_employee.id', '=', $user->id)
                    ->get();
                $allws = DB::table('x_transact_allowances')
                    ->join('x_employee', 'x_transact_allowances.employee_id', '=', 'x_employee.id')
                    ->where('x_transact_allowances.organization_id', Auth::user()->organization_id)
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', $user->id)
                    ->select('allowance_name', DB::raw('SUM(allowance_amount) as total_amount'))
                    ->groupBy('allowance_name')
                    ->get();

                $earnings = DB::table('x_transact_earnings')
                    ->join('x_employee', 'x_transact_earnings.employee_id', '=', 'x_employee.id')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', $user->id)
                    ->select('earning_name', DB::raw('SUM(earning_amount) as total_amount'))
                    ->groupBy('earning_name')
                    ->get();

                $deds = DB::table('x_transact_deductions')
                    ->join('x_employee', 'x_transact_deductions.employee_id', '=', 'x_employee.id')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', $user->id)
                    ->select('deduction_name', DB::raw('SUM(deduction_amount) as total_amount'))
                    ->groupBy('deduction_name')
                    ->get();

                $currencies = DB::table('x_currencies')
                    ->select('shortname')
                    ->get();

                $organization = Organization::find(1);

                $fyear = '';
                $fperiod = '';

                $part = explode("-", $period);
                $month = intval($part[0]);
                $year = $part[1];

                if ($month == 1) {
                    $fyear = 'January_' . $year;
                    $fperiod = 'January-' . $year;
                } else if ($month == 2) {
                    $fyear = 'February_' . $year;
                    $fperiod = 'February-' . $year;
                } else if ($month == 3) {
                    $fyear = 'March_' . $year;
                    $fperiod = 'March-' . $year;
                } else if ($month == 4) {
                    $fyear = 'April_' . $year;
                    $fperiod = 'April-' . $year;
                } else if ($month == 5) {
                    $fyear = 'May_' . $year;
                    $fperiod = 'May-' . $year;
                } else if ($month == 6) {
                    $fyear = 'June_' . $year;
                    $fperiod = 'June-' . $year;
                } else if ($month == 7) {
                    $fyear = 'July_' . $year;
                    $fperiod = 'July-' . $year;
                } else if ($month == 8) {
                    $fyear = 'August_' . $year;
                    $fperiod = 'August-' . $year;
                } else if ($month == 9) {
                    $fyear = 'September_' . $year;
                    $fperiod = 'September-' . $year;
                } else if ($month == 10) {
                    $fyear = 'October_' . $year;
                    $fperiod = 'October-' . $year;
                } else if ($month == 11) {
                    $fyear = 'November_' . $year;
                    $fperiod = 'November-' . $year;
                } else if ($month == 12) {
                    $fyear = 'December_' . $year;
                    $fperiod = 'December-' . $year;
                }

                $overtimes = DB::table('x_transact_overtimes')
                    ->join('x_employee', 'x_transact_overtimes.employee_id', '=', 'x_employee.id')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', request('employeeid'))
                    ->select('employee_id', DB::raw('SUM(overtime_amount) as total_overtime'))
                    ->groupBy('employee_id')
                    ->get();
                $nontaxables = DB::table('x_transact_nontaxables')
                    ->join('x_employee', 'x_transact_nontaxables.employee_id', '=', 'x_employee.id')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', request('employeeid'))
                    ->select('nontaxable_name', DB::raw('SUM(nontaxable_amount) as total_amount'))
                    ->groupBy('nontaxable_name')
                    ->get();
                $rels = DB::table('x_transact_reliefs')
                    ->join('x_employee', 'x_transact_reliefs.employee_id', '=', 'x_employee.id')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', request('employeeid'))
                    ->select('relief_name', DB::raw('SUM(relief_amount) as total_amount'))
                    ->groupBy('relief_name')
                    ->get();
                $pension = DB::table('x_transact_pensions')
                    ->join('x_employee', 'x_transact_pensions.employee_id', '=', 'x_employee.id')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', request('employeeid'))
                    ->first();

                $select = "ALL";

                $fileName = $user->first_name . '_' . $user->last_name . '_' . $fyear . '.pdf';
                $filePath = storage_path('app/temp/');
                $pdf = PDF::loadView('pdf.monthlySlip', compact('pension', 'nontaxables', 'rels', 'employees', 'select', 'transacts', 'allws', 'deds', 'earnings', 'period', 'currencies', 'organization', 'overtimes'))->setPaper('a4');

                if (!file_exists($filePath)) {
                    mkdir($filePath, 0777, true);
                }
                $pdf->save($filePath . $fileName);

                Mail::send('payslips.message', compact('fperiod', 'user'), function ($message) use ($user, $filePath, $fileName) {
                    $message->to($user->email_office, $user->first_name . ' ' . $user->last_name)->subject('Payslip');
                    $message->attach($filePath . $fileName);
                });
                unlink($filePath . $fileName);
            }
            return Redirect::back()->with('success', 'Email Sent!');
        } else if (empty(request('sel')) && !empty(request('employeeid'))) {
            $period = request('period');
            $employees = Employee::all();

            $emps = DB::table('x_employee')->count();

            $id = request('employeeid');

            $employee = Employee::find($id);
            $transacts = DB::table('x_transact')
                ->join('x_employee', 'x_transact.employee_id', '=', 'x_employee.personal_file_number')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->get();
//            dd($transacts);

            $allws = DB::table('x_transact_allowances')
                ->join('x_employee', 'x_transact_allowances.employee_id', '=', 'x_employee.id')
                ->where('x_transact_allowances.organization_id', Auth::user()->organizationId)
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->select('allowance_name', DB::raw('SUM(allowance_amount) as total_amount'))
                ->groupBy('allowance_name')
                ->get();

            $overtimes = DB::table('x_transact_overtimes')
                ->join('x_employee', 'x_transact_overtimes.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->select('employee_id', DB::raw('SUM(overtime_amount) as total_overtime'))
                ->groupBy('employee_id')
                ->get();

            $earnings = DB::table('x_transact_earnings')
                ->join('x_employee', 'x_transact_earnings.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->select('earning_name', DB::raw('SUM(earning_amount) as total_amount'))
                ->groupBy('earning_name')
                ->get();

            $deds = DB::table('x_transact_deductions')
                ->join('x_employee', 'x_transact_deductions.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))->select('deduction_name', DB::raw('SUM(deduction_amount) as total_amount'))
                ->groupBy('deduction_name')
                ->get();
            $nontaxables = DB::table('x_transact_nontaxables')
                ->join('x_employee', 'x_transact_nontaxables.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->select('nontaxable_name', DB::raw('SUM(nontaxable_amount) as total_amount'))
                ->groupBy('nontaxable_name')
                ->get();
            $rels = DB::table('x_transact_reliefs')
                ->join('x_employee', 'x_transact_reliefs.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->select('relief_name', DB::raw('SUM(relief_amount) as total_amount'))
                ->groupBy('relief_name')
                ->get();

            $pension = DB::table('x_transact_pensions')
                ->join('x_employee', 'x_transact_pensions.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->first();

            $currencies = DB::table('x_currencies')
                ->select('shortname')
                ->first();

            $organization = Organization::find(1);

            $fyear = '';
            $fperiod = '';

            $part = explode("-", $period);
            $month = intval($part[0]);
            $year = $part[1];

            if ($month == 1) {
                $fyear = 'January_' . $year;
                $fperiod = 'January-' . $year;
            } else if ($month == 2) {
                $fyear = 'February_' . $year;
                $fperiod = 'February-' . $year;
            } else if ($month == 3) {
                $fyear = 'March_' . $year;
                $fperiod = 'March-' . $year;
            } else if ($month == 4) {
                $fyear = 'April_' . $year;
                $fperiod = 'April-' . $year;
            } else if ($month == 5) {
                $fyear = 'May_' . $year;
                $fperiod = 'May-' . $year;
            } else if ($month == 6) {
                $fyear = 'June_' . $year;
                $fperiod = 'June-' . $year;
            } else if ($month == 7) {
                $fyear = 'July_' . $year;
                $fperiod = 'July-' . $year;
            } else if ($month == 8) {
                $fyear = 'August_' . $year;
                $fperiod = 'August-' . $year;
            } else if ($month == 9) {
                $fyear = 'September_' . $year;
                $fperiod = 'September-' . $year;
            } else if ($month == 10) {
                $fyear = 'October_' . $year;
                $fperiod = 'October-' . $year;
            } else if ($month == 11) {
                $fyear = 'November_' . $year;
                $fperiod = 'November-' . $year;
            } else if ($month == 12) {
                $fyear = 'December_' . $year;
                $fperiod = 'December-' . $year;
            }

            $select = "";
            //            dd($overtimes);
            $fileName = $employee->first_name . '_' . $employee->last_name . '_' . $fyear . '.pdf';
            $filePath = storage_path('app/temp/');
            $pdf = PDF::loadView('pdf.monthlySlip', compact(
                'employee',
                'nontaxables',
                'select',
                'transacts',
                'allws',
                'deds',
                'earnings',
                'period',
                'currencies',
                'organization',
                'overtimes',
                'rels',
                'pension'
            ))->setPaper('a4');

            if (!file_exists($filePath)) {
                mkdir($filePath, 0777, true);
            }
            $pdf->save($filePath . $fileName);

            Mail::send('payslips.message', ['fperiod' => $fperiod, 'user' => $employee], function ($message) use ($employee, $filePath, $fileName) {
                $message->to($employee->email_office, $employee->first_name . ' ' . $employee->last_name)->subject('Payslip');
                $message->attach($filePath . $fileName);
            });
            unlink($filePath . $fileName);
        }
        return Redirect::back()->with('success', 'Email Sent!');
    }
}
