<?php

namespace App\Http\Controllers;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\SmsModel;
use App\Models\Account;
use App\Models\Allowance;
use App\Models\Audit;
use App\Models\Currency;
use App\Models\Dailypay;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Earningsetting;
use App\Models\Email;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\Jobgroup;
use App\Models\Lockpayroll;
use App\Models\Nontaxable;
use App\Models\Organization;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Models\Relief;
use App\Models\License;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Classes\PHPExcel;
use Maatwebsite\Excel\Facades\Excel;
use Zizaco\Entrust\Entrust;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\Console\Input\Input as InputInput;
use Illuminate\Support\Facades\Log;
use Exception;
use SMSLeopard\Client;

class PayrollController extends Controller
{

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if(!isset(Auth::user()->organization_id)){
            return redirect('login');
        }
        $accounts = Account::where('organization_id', Auth::user()->organization_id)->get();

        $department = Department::whereNull('organization_id')
            ->orWhere('organization_id', Auth::user()->organization_id)
            ->where('name', 'Management')->first();
        $jgroups = Jobgroup::where(function ($query) {
            $query->whereNull('organization_id')
                ->orWhere('organization_id', Auth::user()->organization_id);
        })->get();
        //        if ($jgroup != null) {
        //            $type = Employee::where('organization_id', Auth::user()->organization_id)->where('job_group_id', $jgroup->id)->where('personal_file_number', Auth::user()->username)->count();
        //        } else {
        //            $type = Employee::where('organization_id', Auth::user()->organization_id)->/*where('job_group_id',$jgroup->id)->*/ where('personal_file_number', Auth::user()->username)->count();
        //        }
        return View::make('payroll.index', compact('accounts', 'jgroups'));
    }

    public function unlockindex()
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        //        $transacts = DB::table('x_transact')->where('organization_id', Auth::user()->organization_id)->orderBy('id', 'Desc')->simplepaginate(10);
        $transacts = DB::table('x_transact')->where('organization_id', Auth::user()->organization_id)->groupBy('financial_month_year', 'id', 'organization_id')->orderBy('id', 'Desc')->simplepaginate(10);

        return View::make('payroll.unlockindex', compact('transacts'));
    }

    public function viewpayroll($id)
    {

        $transact = DB::table('x_transact')->find($id);

        return View::make('payroll.viewpayroll', compact('transact'));
    }

    public function unlockpayroll($id)
    {

        $transact = DB::table('x_transact')->find($id);

        if (Lockpayroll::where('period', $transact->financial_month_year)->count() > 0) {
            return Redirect::to('unlockpayroll/index');
        }

        $users = User::where('user_type', 'admin')->where('id', '!=', Auth::user()->id)->where('organization_id', Auth::user()->organization_id)->get();
        return View::make('payroll.unlockpayroll', compact('transact', 'users'));
    }

    public function dounlockpayroll()
    {
        $period = Carbon::createFromFormat('m-Y', request('period'))->format('Y-m-d');

        // Check if the period is valid
        if (!$period) {
            return redirect('unlockpayroll/index')->with('error', 'Invalid period format');
        }

        // Check if the user ID is valid
        $userId = request('userid');
        if (!$userId) {
            return redirect('unlockpayroll/index')->with('error', 'Invalid user ID');
        }

        // Check if the user exists
        $user = User::find($userId);
        if (!$user) {
            return redirect('unlockpayroll/index')->with('error', 'User not found');
        }

        // Check if the payroll is already unlocked
        if (Lockpayroll::where('period', $period)->where('user_id', $userId)->exists()) {
            return redirect('unlockpayroll/index')->with('notice', 'Payroll for period ' . request('period') . ' already unlocked to user ' . $user->name);
        }

        // Unlock the payroll
        $unlock = new Lockpayroll;
        $unlock->user_id = $userId;
        $unlock->authorized_by = Auth::user()->id;
        $unlock->organization_id = Auth::user()->organization_id;
        $unlock->period = $period;
        if (!$unlock->save()) {
            return redirect('unlockpayroll/index')->with('error', 'Failed to unlock payroll');
        }

        return redirect('unlockpayroll/index')->with('notice', 'Payroll for period ' . request('period') . ' successfully unlocked to user ' . $user->name);
    }

    public function createaccount()
    {
        $postaccount = request()->all();
        $data = array(
            'name' => $postaccount['name'],
            'code' => $postaccount['code'],
            'category' => $postaccount['category'],
            'balance' => 0,
            'active' => 1,
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        );
        $check = DB::table('x_accounts')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Accounts', 'create', 'created: ' . $postaccount['name'],NULL,Auth::user()->organization_id);
            return $check;
        } else {
            return 1;
        }
    }

    public function preview_payroll()
    {
        $employees = DB::table('employee')
            ->where('in_employment', '=', 'Y')
            ->where('employee.organization_id', Auth::user()->organization_id)
            ->get();

        $earnings = Earningsetting::all();

        //print_r($accounts);

        Audit::logaudit('Payroll', 'preview', 'previewed payroll',NULL,Auth::user()->organization_id);


        return View::make('payroll.preview', compact('employees', 'earnings'));
    }

    public function valid()
    {
        $period = request('period');

        //print_r($accounts);

        return View::make('payroll.valid', compact('period'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        set_time_limit(2000);

        $type = request('type');
        $period = request('period');
        $period_date = \Carbon\Carbon::createFromFormat('m-Y', $period)->format('Y-m-d');

        $unlock = Lockpayroll::where('user_id', Auth::user()->id)
            ->where('period', $period_date)
            ->count();

        $user_can_reprocess = \Illuminate\Support\Facades\Gate::allows('reprocess_payroll');
        $check = DB::table('x_transact')
            ->where('financial_month_year', '=', $period_date)
            ->where('organization_id', Auth::user()->organization_id)
            ->count();

        if (!$user_can_reprocess && $unlock == 0) {
            if ($check > 0) {
                return redirect()->back()->with('notice', 'Payroll for this month is already processed! Please contact the admin if you wish to re-process it...');
            }
        }

        $period = request('period');
        $date = Carbon::createFromFormat('m-Y', $period);
        $start = $date->startOfMonth()->format('Y-m-d');
        $end = $date->endOfMonth()->format('Y-m-d');

        $employees = DB::table('x_employee')
            ->where('in_employment', '=', 'Y')
            ->where('organization_id', Auth::user()->organization_id)
            ->whereDate('date_joined', '<=', $end)
            ->get();

        $department = Department::where('name', 'Management')
            ->where(function ($query) {
                $query->whereNull('organization_id')
                    ->orWhere('organization_id', Auth::user()->organization_id);
            })->first();

        $jgroup = Jobgroup::whereRaw('LOWER(job_group_name) = ?', [strtolower($type)])
            ->where(function ($query) {
                $query->whereNull('organization_id')
                    ->orWhere('organization_id', Auth::user()->organization_id);
            })->first();

        // Check for management category using lowercase
        if (strtolower($type) == "management" && !$jgroup) {
            return redirect()->back()->with('notice', 'There are no employees in the management category, Kindly add employees to this category to continue...');
        }

        if (strtolower($type) == 'management') {

            $employees = DB::table('x_employee')
                ->where('in_employment', '=', 'Y')
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', $jgroup->id)
                ->whereDate('date_joined', '<=', $end)
                ->get();
        } else {
            $employees = DB::table('x_employee')
                ->where('in_employment', '=', 'Y')
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', '=', $jgroup->id)
                ->whereDate('date_joined', '<=', $end)
                ->get();
        }


        $type = request('type');
        $account = request('account');
        $earnings = Earningsetting::where('organization_id', Auth::user()->organization_id)->orWhereNull('organization_id')->get();
        //$pays = Dailypay::where('organization_id',Auth::user()->organization_id)->get();
        $overtimes = Overtime::all();
        $allowances = Allowance::where('organization_id', Auth::user()->organization_id)
            ->orWhereNull('organization_id')->get();
        //        dd($allowances);
        $nontaxables = Nontaxable::where('organization_id', Auth::user()->organization_id)
            ->orWhereNull('organization_id')->get();
        //        dd($nontaxables);
        $reliefs = Relief::where('organization_id', Auth::user()->organization_id)
            ->orWhereNull('organization_id')->get();
        $deductions = Deduction::where('organization_id', Auth::user()->organization_id)
            ->orWhereNull('organization_id')->get();
        //        print_r($accounts);
        // var_dump($overtimes); echo "<br><br>";

        Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'preview', 'previewed payroll',NULL,Auth::user()->organization_id);

        return View::make('payroll.preview', compact('employees', 'period', 'account', 'nontaxables', 'earnings', 'overtimes', 'allowances', 'reliefs', 'deductions', 'type'));
    }

    public function del_exist()
    {
        $postedit = Input::all();
        $part1 = $postedit['period1'];
        $part2 = $postedit['period2'];
        $part3 = $postedit['period3'];
        $type = $postedit['type'];

        $period = $part1 . $part2 . $part3;

        DB::table('employee_allowances')
            ->join('transact_allowances', 'employee_allowances.id', '=', 'transact_allowances.employee_allowance_id')
            ->where('transact_allowances.organization_id', Auth::user()->organization_id)
            ->where('process_type', $type)
            ->where(function ($query) {
                $query->where('formular', '=', 'One Time')
                    ->orWhere('formular', '=', 'Instalments');
            })
            ->increment('instalments');

        DB::table('employeenontaxables')
            ->join('transact_nontaxables', 'employeenontaxables.id', '=', 'transact_nontaxables.employee_nontaxable_id')
            ->where('financial_month_year', '=', $period)
            ->where('transact_nontaxables.organization_id', Auth::user()->organization_id)
            ->where('process_type', $type)
            ->where(function ($query) {
                $query->where('formular', '=', 'One Time')
                    ->orWhere('formular', '=', 'Instalments');
            })
            ->increment('instalments');

        DB::table('employee_deductions')
            ->join('transact_deductions', 'employee_deductions.id', '=', 'transact_deductions.employee_deduction_id')
            ->where('financial_month_year', '=', $period)
            ->where('transact_deductions.organization_id', Auth::user()->organization_id)
            ->where('process_type', $type)
            ->where(function ($query) {
                $query->where('formular', '=', 'One Time')
                    ->orWhere('formular', '=', 'Instalments');
            })
            ->increment('instalments');

        DB::table('earnings')
            ->join('transact_earnings', 'earnings.id', '=', 'transact_earnings.earning_id')
            ->where('financial_month_year', '=', $period)
            ->where('transact_earnings.organization_id', Auth::user()->organization_id)
            ->where('process_type', $type)
            ->where(function ($query) {
                $query->where('formular', '=', 'One Time')
                    ->orWhere('formular', '=', 'Instalments');
            })
            ->increment('instalments');

        DB::table('overtimes')
            ->join('transact_overtimes', 'overtimes.id', '=', 'transact_overtimes.overtime_id')
            ->where('financial_month_year', '=', $period)
            ->where('transact_overtimes.organization_id', Auth::user()->organization_id)
            ->where('process_type', $type)
            ->where(function ($query) {
                $query->where('formular', '=', 'One Time')
                    ->orWhere('formular', '=', 'Instalments');
            })
            ->increment('instalments');

        //DB::table('dailypays')->where('period',$period)->where('status',1)->update(array("status"=>0));


        $data = DB::table('transact')->where('process_type', $type)->where('organization_id', Auth::user()->organization_id)->where('financial_month_year', $period)->delete();
        $data2 = DB::table('transact_allowances')->where('process_type', $type)->where('organization_id', Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
        $data3 = DB::table('transact_deductions')->where('process_type', $type)->where('organization_id', Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
        $data4 = DB::table('transact_earnings')->where('process_type', $type)->where('organization_id', Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
        $data5 = DB::table('transact_overtimes')->where('process_type', $type)->where('organization_id', Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
        $data6 = DB::table('transact_reliefs')->where('process_type', $type)->where('organization_id', Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
        $data7 = DB::table('transact_nontaxables')->where('process_type', $type)->where('organization_id', Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();
        $data8 = DB::table('transact_pensions')->where('organization_id', Auth::user()->organization_id)->where('financial_month_year', '=', $period)->delete();

        if ($data > 0) {
            return 0;
        } else {
            return 1;
        }


        exit();
    }


    public function disp()
    {
        $display = "";
        $postedit = request()->all();
        parse_str(request('formdata'), $postedit);
        $gross = str_replace(',', '', $postedit['gross']);
        //        dd($gross);
        $paye = number_format(Payroll::payecalc($gross), 2);
        $nssf = number_format(Payroll::nssfcalc($gross), 2);
        $nhif = number_format(Payroll::nhifcalc($gross), 2);
        $net = Payroll::asMoney(Payroll::netcalc($gross));

        return json_encode(["paye" => $paye, "nssf" => $nssf, "nhif" => $nhif, "net" => $net, "gross" => number_format($gross, 2)]);
        //echo json_encode(array("paye"=>$paye,"nssf"=>$nssf,"nhif"=>$nhif));
        //$net = number_format(Payroll::netcalc($employee->id,$fperiod),2);
        /*

        $display .="
          <input class='form-control' placeholder='' type='text' name='gross' id='gross' value='$gross'>
          <input readonly class='form-control' placeholder='' type='text' name='paye' id='paye' value='$paye'>
          <input readonly class='form-control' placeholder='' type='text' name='nssf' id='nssf' value='$nssf'>
          <input readonly class='form-control' placeholder='' type='text' name='nssf' id='nhif' value='$nhif'>
          <input readonly class='form-control' placeholder='' type='text' name='net' id='net' value='0'>

        ";

        return $display;
        exit();*/
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();
        //return View::make('payroll.payroll_calculator', compact('gross','paye','nssf','nhif','currency'));


        echo json_encode(array("paye" => $paye, "nssf" => $nssf, "nhif" => $nhif));
        //return $display;
        exit();
    }


    public static function grosscalc($net)
    {

        $total = 0;
        $gross = $net;
        $y = 0;
        $x = 0;

        for ($i = $net; $i > 0; $i--) {

            $total = $net - Payroll::payencalc($net) - Payroll::nssfncalc($net) - Payroll::nhifncalc($net);

            $gross = ($gross - $total) + $net;
            $net = $total;
            $y = $x;
            $x = ($gross - $net) / 2;
            $i = $x - $y;
        }

        return round($gross, 2);
    }


    public function previewprint($period)
    {

        $data = DB::table('x_employee')
            ->where('in_employment', '=', 'Y')
            ->where('organization_id', Auth::user()->organization_id)
            ->get();
        $period = $period;
        $account = request('account');
        $earnings = Earningsetting::all();
        $overtimes = Overtime::all();
        $allowances = Allowance::all();
        $reliefs = Relief::all();
        $deductions = Deduction::all();

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();

        $organization = Organization::find(Auth::user()->organization_id);

        $part = explode("-", $period);

        $m = "";

        if (strlen($part[0]) == 1) {
            $m = "0" . $part[0];
        } else {
            $m = $part[0];
        }

        $month = $m . "_" . $part[1];


        Excel::create('Payroll_Preview_' . $month, function ($excel) use ($data, $month, $period, $earnings, $overtimes, $allowances, $reliefs, $deductions) {

            require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
            require_once(base_path() . "/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


            $objPHPExcel = new PHPExcel();
            // Set the active Excel worksheet to sheet 0
            $objPHPExcel->setActiveSheetIndex(0);


            $excel->sheet('Payroll_Preview_' . $month, function ($sheet) use ($data, $month, $period, $earnings, $overtimes, $allowances, $reliefs, $deductions) {
                $earnname = '';
                $earns = array();
                $allws = array();
                $rels = array();
                $deds = array();

                foreach ($earnings as $earning) {
                    $earns[] = "'" . $earning->earning_name . "'";
                }

                $earnname = implode(',', $earns);

                foreach ($allowances as $allowance) {
                    $allws[] = $allowance->allowance_name;
                }

                foreach ($reliefs as $relief) {
                    $rels[] = $relief->relief_name;
                }

                foreach ($deductions as $deduction) {
                    $deds[] = $deduction->deduction_name;
                }


                $sheet->row(2, array(
                    'Payroll Preview for ' . $period
                ));

                $sheet->cell('A2', function ($cell) {

                    // manipulate the cell
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                });


                $sheet->mergeCells('A2:K2');

                $sheet->row(3, array(
                    '#', 'PF Number', 'Employee', 'Basic Pay', $earnname, 'Overtime-Hourly', 'Overtime-Daily', implode(",", $allws),
                    'Gross Pay', 'Total Tax', 'Tax Relief', implode(",", $rels), 'Paye', 'Nssf', 'Nhif', implode(",", $deds), 'Total Deductions', 'Net Pay'
                ));

                $sheet->cells('A3:D3', array(
                    '#', 'PF Number', 'Employee', 'Basic Pay'
                ));

                $sheet->row(3, function ($r) {

                    // call cell manipulation methods
                    $r->setFontWeight('bold');
                });

                $row = 4;


                for ($i = 0; $i < count($data); $i++) {

                    $sheet->row($row, array(
                        $i + 1, $data[$i]->personal_file_number, $data[$i]->first_name . ' ' . $data[$i]->last_name, number_format(floatval($data[$i]->basic_pay), 2)
                    ));

                    $sheet->cell('C' . $row, function ($cell) {

                        // manipulate the cell
                        $cell->setAlignment('right');
                    });

                    $sheet->cell('D' . $row, function ($cell) {

                        // manipulate the cell
                        $cell->setAlignment('right');
                    });

                    $sheet->cell('E' . $row, function ($cell) {

                        // manipulate the cell
                        $cell->setAlignment('right');
                    });

                    $sheet->cell('F' . $row, function ($cell) {

                        // manipulate the cell
                        $cell->setAlignment('right');
                    });

                    $sheet->cell('G' . $row, function ($cell) {

                        // manipulate the cell
                        $cell->setAlignment('right');
                    });

                    $sheet->cell('H' . $row, function ($cell) {

                        // manipulate the cell
                        $cell->setAlignment('right');
                    });

                    $sheet->cell('I' . $row, function ($cell) {

                        // manipulate the cell
                        $cell->setAlignment('right');
                    });

                    $sheet->cell('J' . $row, function ($cell) {

                        // manipulate the cell
                        $cell->setAlignment('right');
                    });

                    $sheet->cell('K' . $row, function ($cell) {

                        // manipulate the cell
                        $cell->setAlignment('right');
                    });

                    $row++;
                }
                /*$sheet->row($row, array(
             '','Total: ',number_format(floatval($total_pay), 2),number_format(floatval($total_earning), 2),number_format(floatval($total_gross), 2),number_format(floatval($total_paye), 2),number_format(floatval($total_nssf), 2),number_format(floatval($total_nhif), 2),number_format(floatval($total_others), 2),number_format(floatval($total_deds), 2),number_format(floatval($total_net), 2)
             ));*/
                /*$sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');

              });
            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('E'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('F'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('G'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('I'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('J'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->cell('K'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $sheet->row($row+1, array(
             '','','','','','','','','','Total Net: ',number_format(floatval($total_net), 2)
             ));
            $sheet->row($row+1, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');

              });
            $sheet->cell('K'.($row+1), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });*/
            });
        })->download('xls');
    }

    public function asMoney($value)
    {

        return number_format($value, 2);
    }

    public function dispgross()
    {
        $display = "";
        $postedit = request()->all();
        parse_str(request('formdata'), $postedit);
        $net = str_replace(',', '', $postedit['net1']);
        //print_r($searcharray['net1']);

        $total = 0;
        $gross = $net;
        $y = 0;
        $x = 0;
        $a = 0;
        $z = str_replace(',', '', $postedit['net1']);


        $paye1 = 0;
        $nssf1 = 0;
        $nhif1 = 0;

        for ($i = $net;; $i--) {

            /*$nssf1 = DB::table('social_security')->whereNull('organization_id')->whereRaw($gross.' between income_from and income_to')->pluck('ss_amount_employee');

        $nhif1 = DB::table('hospital_insurance')->whereNull('organization_id')->whereRaw($gross.' between income_from and income_to')->pluck('hi_amount');    */

            $nssf1 = Payroll::nssfcalc($gross);
            $nhif1 = Payroll::nhifcalc($gross);

            $taxable = $gross - $nssf1;

            if ($taxable >= 13686 && $taxable < 23884) {
                $paye1 = (1229.8 + ($taxable - 12298) * 15 / 100) - 1408.00;
            } else if ($taxable >= 23884 && $taxable < 35470) {
                $paye1 = ((1229.8 + ((11586.92) * 0.15)) + ($taxable - 23884) * 20 / 100) - 1408.00;
            } else if ($taxable >= 35470 && $taxable < 47059) {
                $paye1 = ((1229.8 + (11586.92 * 0.15) + ((11586.92) * 0.2)) + ($taxable - 35470) * 25 / 100) - 1408.00;
            } else if ($taxable >= 47059) {
                $paye1 = ((1229.8 + (11586.92 * 0.15) + (11586.92 * 0.2) + ((11586.92) * 0.25)) + ($taxable - 47059) * 30 / 100) - 1408.00;
            } else {
                $paye1 = 0.00;
            }
            $total = $net - $paye1 - $nssf1 - $nhif1;
            $gross = ($z - $total) + $net;
            $net = $total;
            $y = $x;
            $x = ($gross - $net) / 2;
            if ($net + $x == 40000) {
                $i = ($x - $y);
            } else {
                if (round($a - ($x - $y), 2) == 0) {
                    if ($gross < 0) {
                        $gross = 0;
                    } else {
                        $gross = $gross;
                    }
                    break;
                } else {
                    $i = $a - ($x - $y);
                }
            }
            $a = ($x - $y);
            //echo $gross.'<br>';
        }


        // echo $nssf1;
        //return $display;

        return json_encode(["paye1" => number_format($paye1, 2), "nssf1" => number_format($nssf1, 2), "nhif1" => number_format($nhif1, 2), "netv" => number_format($z, 2), "gross1" => number_format($gross, 2)]);
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();
    }


    public function display()
    {
        $display = "";
        $postedit = request()->all();
        $part1 = $postedit['period1'];
        $part2 = $postedit['period2'];
        $part3 = $postedit['period3'];
        $type = $postedit['type'];

        $fperiod = $part1 . $part2 . $part3;

        $start = date('Y-m-01', strtotime("01-" . $fperiod));
        $end = date('Y-m-t', strtotime("01-" . $fperiod));


        $employees = DB::table('employee')
            ->where('in_employment', '=', 'Y')
            ->where('organization_id', Auth::user()->organization_id)
            ->whereDate('date_joined', '<=', $end)
            ->get();

        $department = Department::where('department_name', 'Management')
            ->where(function ($query) {
                $query->whereNull('organization_id')
                    ->orWhere('organization_id', Auth::user()->organization_id);
            })->first();

        $jgroup = Jobgroup::where('job_group_name', 'Management')
            ->where(function ($query) {
                $query->whereNull('organization_id')
                    ->orWhere('organization_id', Auth::user()->organization_id);
            })->first();

        if ($type == 'management') {

            $employees = DB::table('employee')
                ->where('in_employment', '=', 'Y')
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', $jgroup->id)
                ->whereDate('date_joined', '<=', $end)
                ->get();
        } else {
            $employees = DB::table('employee')
                ->where('in_employment', '=', 'Y')
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', '!=', $jgroup->id)
                ->whereDate('date_joined', '<=', $end)
                ->get();
        }

        $i = 1;
        $salary = 0.00;
        $earningA = 0;
        $hourly = 0;
        $Daily = 0;
        $allowanceA = 0;
        $nontaxableA = 0;
        $reliefA = 0;
        $deductionA = 0;
        $taxrelief = 0.00;
        $totalsalary = 0.00;
        $totalearning = 0.00;
        $totalhourly = 0.00;
        $totaldaily = 0.00;
        $totalallowance = 0.00;
        $totalnontaxable = 0.00;
        $totalrelief = 0.00;
        $totalgross = 0.00;
        $totaltax = 0.00;
        $totaltaxrelief = 0.00;
        $totalpaye = 0.00;
        $totalnssf = 0.00;
        $totalnhif = 0.00;
        $totalpension = 0.00;
        $otherdeduction = 0.00;
        $totaldeduction = 0.00;
        $totalnet = 0.00;


        $earnings = Earningsetting::where('organization_id', Auth::user()->organization_id)
            ->orWhereNull('organization_id')->get();
        $pays = Dailypay::where('organization_id', Auth::user()->organization_id)->get();
        $overtimes = Overtime::all();
        $allowances = Allowance::where('organization_id', Auth::user()->organization_id)
            ->orWhereNull('organization_id')->get();
        $nontaxables = Nontaxable::where('organization_id', Auth::user()->organization_id)
            ->orWhereNull('organization_id')->get();
        $reliefs = Relief::where('organization_id', Auth::user()->organization_id)->orWhereNull('organization_id')->get();
        $deductions = Deduction::where('organization_id', Auth::user()->organization_id)->orWhereNull('organization_id')->get();


        foreach ($employees as $employee) {

            $salary = number_format(Payroll::basicpay($employee->id, request('period')), 2);

            $hourly = number_format(Payroll::overtimes($employee->id, 'Daily', $fperiod), 2);
            $daily = number_format(Payroll::overtimes($employee->id, 'Hourly', $fperiod), 2);
            $gross = number_format(Payroll::gross($employee->id, $fperiod), 2);
            $tax = number_format(Payroll::totaltax($employee->id, $fperiod), 2);
            if ($employee->income_tax_applicable == 1 && (float)Payroll::gross($employee->id, $fperiod) >= 11180 && $employee->income_tax_relief_applicable == 1) {
                $taxrelief = number_format('1408', 2);
            } else {
                $taxrelief = number_format('0.00', 2);
            }
            $paye = number_format(Payroll::tax($employee->id, $fperiod), 2);
            $nssf = number_format(Payroll::nssf($employee->id, $fperiod), 2);
            $nhif = number_format(Payroll::nhif($employee->id, $fperiod), 2);
            $pension = number_format(Payroll::pension($employee->id, $fperiod), 2);
            $total_deductions = number_format(Payroll::total_deductions($employee->id, $fperiod), 2);
            $net = number_format(Payroll::net($employee->id, $fperiod), 2);

            $totalsalary = $totalsalary + (float)Payroll::basicpay($employee->id, request('period'));
            $totalhourly = $totalhourly + (float)Payroll::overtimes($employee->id, 'Hourly', $fperiod);
            $totaldaily = $totaldaily + (float)Payroll::overtimes($employee->id, 'Daily', $fperiod);
            $totalgross = $totalgross + (float)Payroll::gross($employee->id, $fperiod);
            $totaltax = $totaltax + (float)Payroll::totaltax($employee->id, $fperiod);
            if ($employee->income_tax_applicable == 1 && (float)Payroll::gross($employee->id, $fperiod) >= 11180 && $employee->income_tax_relief_applicable == 1) {
                $totaltaxrelief = $totaltaxrelief + 1408;
            }
            $totalpaye = $totalpaye + (float)Payroll::tax($employee->id, $fperiod);
            $totalnssf = $totalnssf + (float)Payroll::nssf($employee->id, $fperiod);
            $totalnhif = $totalnhif + (float)Payroll::nhif($employee->id, $fperiod);
            $totalpension = $totalpension + (float)Payroll::pension($employee->id, $fperiod);
            $totaldeduction = $totaldeduction + (float)Payroll::total_deductions($employee->id, $fperiod);
            $totalnet = $totalnet + (float)Payroll::net($employee->id, $fperiod);

            $display .= "
        <tr>

          <td> $i </td>
          <td >$employee->personal_file_number</td>
          <td>$employee->first_name $employee->last_name </td>
          <td align='right'>$salary</td>
          ";
            foreach ($earnings as $earning) {
                $earningA = number_format(Payroll::earnings($employee->id, $earning->id, $fperiod), 2);
                $display .= "<td align='right'>$earningA</td>";
            }
            $display .= "<td align='right'>$hourly</td>
          <td align='right'>$daily</td>";
            foreach ($allowances as $allowance) {
                $allowanceA = number_format(Payroll::allowances($employee->id, $allowance->id, $fperiod), 2);
                $display .= "<td align='right'>$allowanceA</td>";
            }
            $display .= "<td align='right'>$gross</td>";
            foreach ($nontaxables as $nontaxable) {
                $nontaxableA = number_format(Payroll::nontaxables($employee->id, $nontaxable->id, $fperiod), 2);
                $display .= "<td align='right'>$nontaxableA</td>";
            }
            $display .= "<td align='right'>$tax</td>
                      <td align='right'>$taxrelief</td>
          ";
            foreach ($reliefs as $relief) {
                $reliefA = number_format(Payroll::reliefs($employee->id, $relief->id, $fperiod), 2);
                $display .= "<td align='right'>$reliefA</td>";
            }
            $display .= "<td align='right'>$paye</td>
          <td align='right'>$nssf</td>
          <td align='right'>$nhif</td>";
            foreach ($deductions as $deduction) {
                $deductionA = number_format(Payroll::deductions($employee->id, $deduction->id, $fperiod), 2);
                $display .= "<td align='right'>$deductionA</td>";
            }
            $display .= "<td align='right'>$pension</td><td align='right'>$total_deductions</td>
          <td align='right'>$net</td>

          </tr>";
            $i++;
        }

        $display .= "<tr style='background:#EEE;'>
          <td style='border-right:0 #FFF;'><span style='display:none'>$i</span></td>
          <td></td>
          <td align='right'><strong>Totals</strong></td>
          <td align='right'><strong>" . number_format($totalsalary, 2) . "</strong></td>";
        foreach ($earnings as $earning) {
            $totalearning . $earning->id = $totalearning + (float)Payroll::totalearnings($earning->id, $fperiod, '');
            $display .= "<td align='right'><strong>" . number_format($totalearning . $earning->id, 2) . "</strong></td>";
        }
        $display .= "<td align='right'><strong>" . number_format($totalhourly, 2) . "</strong></td>
           <td align='right'><strong>" . number_format($totaldaily, 2) . "</strong></td>";
        foreach ($allowances as $allowance) {
            $totalallowance . $allowance->id = $totalallowance + (float)Payroll::totalallowances($allowance->id, $fperiod, '');
            $display .= "<td align='right'><strong>" . number_format($totalallowance . $allowance->id, 2) . "</strong></td>";
        }

        $display .= "<td align='right'><strong>" . number_format($totalgross, 2) . "</strong></td>";
        foreach ($nontaxables as $nontaxable) {
            $totalnontaxable . $nontaxable->id = $totalnontaxable + (float)Payroll::totalnontaxable($nontaxable->id, $fperiod, '');
            $display .= "<td align='right'><strong>" . number_format($totalnontaxable . $nontaxable->id, 2) . "</strong></td>";
        }
        $display .= "<td align='right'><strong>$totaltax</strong></td>
          <td align='right'><strong>" . number_format($totaltaxrelief, 2) . "</strong></td>";
        foreach ($reliefs as $relief) {
            $totalrelief . $relief->id = $totalrelief + (float)Payroll::totalreliefs($relief->id, $fperiod, '');
            $display .= "<td align='right'><strong>" . number_format($totalrelief . $relief->id, 2) . "</strong></td>";
        }
        $display .= "<td align='right'><strong>" . number_format($totalpaye, 2) . "</strong></td>
          <td align='right'><strong>" . number_format($totalnssf, 2) . "</strong></td>
          <td align='right'><strong>" . number_format($totalnhif, 2) . "</strong></td>";
        foreach ($deductions as $deduction) {
            $otherdeduction . $deduction->id = $otherdeduction + (float)Payroll::totaldeductions($deduction->id, $fperiod, '');
            $display .= "<td align='right'><strong>" . number_format($otherdeduction . $deduction->id, 2) . "</strong></td>";
        }
        $display .= "<td align='right'><strong>" . number_format((float)Payroll::pension($employee->id, $fperiod), 2) . "</strong></td><td align='right'><strong>" . number_format($totaldeduction, 2) . "</strong></td>
          <td align='right'><strong>" . number_format($totalnet, 2) . "</strong></td>
        </tr>
        ";

        return $display;
        exit();
    }


    public function savesms(Request $request)
    {
        $smsupdate = $request->input('text');
        $sms = SmsModel::findOrNew(1);
        $sms->smsdetails = $smsupdate;
        $sms->save();
        return view('employees.sms', ['smsdata' => $sms]);
    }


    public function smsLeopardFunction($employeephoneno, $employee_name, $net, $financial_month_year, $gross_pay, $total_deductions)
    {
        try {
            // Get SMS Leopard credentials from config  
            $accountId = config('services.smsleopard.account_id');
            $accountKey = config('services.smsleopard.account_key');
            $senderId = config('services.smsleopard.sender_id');

            // Get custom message from database (same as your existing logic)
            $smsdata = SmsModel::where('id', 1)->first();
        if ($smsdata) {
            $objectmessage = (object) $smsdata;
            $Themessage = $objectmessage->smsdetails;
        } else {
            $Themessage = '';
        }

            // Initialize SMS Leopard client with correct parameter names
            $client = new Client($accountId, $accountKey);

            // Prepare the message
            $message = "Hi " . $employee_name . ", " . $Themessage . " your total gross salary of " . $gross_pay . " Total deductions of " . $total_deductions . " and the Net pay of " . $net . " for the month of " . $financial_month_year . " has been successfully credited into your account.";

            // Prepare recipients array - SMS Leopard expects this format
            $recipients = [
                ['number' => $employeephoneno]
            ];

            // Send the SMS
            $response = $client->send($senderId, $message, $recipients);

            // Process the response
            $res_recipients = $response['recipients'] ?? [];
            $res_status = $response['status'] ?? 'unknown';

            Log::info('SMS Leopard Response', [
                'status' => $res_status,
                'recipients' => $res_recipients,
                'full_response' => $response
            ]);

            // Process each recipient response (similar to your existing logic)
            if (!empty($res_recipients)) {
                foreach ($res_recipients as $recipient) {
                    $messageId = $recipient['messageId'] ?? '';
                    $status = $recipient['status'] ?? '';
                    $cost = $recipient['cost'] ?? '';
                    $number = $recipient['number'] ?? '';

                    // Log individual recipient details
                    echo "Message ID: " . $messageId . "<br>";
                    echo "Status: " . $status . "<br>";
                    echo "Cost: " . $cost . "<br>";
                    echo "Number: " . $number . "<br>";
                    echo "Message: " . $message . "<br>";

                    // Send data to your webhook endpoint (keeping your existing logic)
                    $this->sendToWebhook($status, $message, $messageId, $number, $cost);
                }
            }

            return $response;
        } catch (Exception $e) {
            Log::error('SMS Leopard Error', [
                'error' => $e->getMessage(),
                'employee_phone' => $employeephoneno,
                'employee_name' => $employee_name
            ]);

            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }

    // Helper method to send data to your webhook (extracted from your existing code)
    private function sendToWebhook($status, $message, $messageId, $number, $cost)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ussdhost.000webhostapp.com/jsonreceive.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'status' => $status,
                'message' => $message,
                'messageid' => $messageId,
                'number' => $number,
                'cost' => $cost
            ]),
            CURLOPT_HTTPHEADER => array(
                'h_api_key: bbd4c579ccf589ce16fb7240d2b8332d0609b90d5e3393c57be8adf51329c8fe',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            Log::warning('Webhook curl error', [
                'error' => curl_error($curl),
                'message_id' => $messageId
            ]);
        } else if ($httpCode >= 400) {
            Log::warning('Webhook HTTP error', [
                'http_code' => $httpCode,
                'response' => $response,
                'message_id' => $messageId
            ]);
        }

        curl_close($curl);
        return $response;
    }


    public function store()
    {
        try {
            // Check subscription
            if (!(License::checkSubscription(Auth::user()->organization_id))) {
                Log::warning('Payroll processing failed: Subscription limit reached', [
                    'organization_id' => Auth::user()->organization_id,
                    'user_id' => Auth::user()->id
                ]);
                return View::make('employees.employeelimit');
            }

            set_time_limit(3000);
            $period = request('period');
            $type = request('type');
            $organizationId = Auth::user()->organization_id;

            Log::info('Starting payroll processing', [
                'period' => $period,
                'type' => $type,
                'organization_id' => $organizationId,
                'user_id' => Auth::user()->id
            ]);

            // Parse period and get date range
            $date = Carbon::createFromFormat('m-Y', $period);
            $start = $date->startOfMonth()->format('Y-m-d');
            $end = $date->endOfMonth()->format('Y-m-d');

            Log::info('Date range calculated', [
                'period' => $period,
                'start_date' => $start,
                'end_date' => $end
            ]);

            // Get job group
            $jgroup = $this->getJobGroup($type);
            if (!$jgroup) {
                Log::error('Job group not found', ['type' => $type, 'organization_id' => $organizationId]);
                return Redirect::route('payroll.index')->withErrors(['Job group not found for type: ' . $type]);
            }

            Log::info('Job group found', ['job_group_id' => $jgroup->id, 'job_group_name' => $jgroup->job_group_name]);

            // Get employees
            $employees = $this->getEmployees($end, $jgroup, $type);
            Log::info('Employees retrieved', ['employee_count' => $employees->count()]);

            if ($employees->isEmpty()) {
                Log::warning('No employees found for processing', [
                    'period' => $period,
                    'type' => $type,
                    'organization_id' => $organizationId
                ]);
                return Redirect::route('payroll.index')->withFlashMessage('No employees found for processing!');
            }

            // Process main payroll records
            $this->processMainPayroll($employees, $period);

            // Process transaction tables - PASS THE PROCESSED EMPLOYEES
            $this->processTransactionTables($start, $end, $jgroup, strtolower($type) == 'management', $employees);

            Log::info('Payroll processing completed successfully', [
                'period' => $period,
                'type' => $type,
                'organization_id' => $organizationId,
                'employees_processed' => $employees->count()
            ]);

            Audit::logaudit(date('Y-m-d'), Auth::user()->name, 'process', 'processed payroll for ' . $period, NULL);

            return Redirect::route('payroll.index')->withFlashMessage('Payroll successfully processed!');
        } catch (Exception $e) {
            Log::error('Payroll processing failed with exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'period' => $period ?? 'unknown',
                'organization_id' => Auth::user()->organization_id ?? 'unknown'
            ]);

            return Redirect::route('payroll.index')->withErrors(['An error occurred during payroll processing. Please try again.']);
        }
    }


    private function getJobGroup($type)
    {
        try {
            $jgroup = Jobgroup::whereNull('organization_id')
                ->orWhere('organization_id', Auth::user()->organization_id)
                ->where('job_group_name', $type)
                ->first();

            Log::info('Job group query executed', [
                'type' => $type,
                'found' => $jgroup ? true : false,
                'organization_id' => Auth::user()->organization_id
            ]);

            return $jgroup;
        } catch (Exception $e) {
            Log::error('Error retrieving job group', [
                'type' => $type,
                'error' => $e->getMessage(),
                'organization_id' => Auth::user()->organization_id
            ]);
            return null;
        }
    }

    private function getEmployees($end, $jgroup, $type)
    {
        try {
            $query = DB::table('x_employee')
                ->where('in_employment', '=', 'Y')
                ->where('organization_id', Auth::user()->organization_id)
                ->whereDate('date_joined', '<=', $end);

            if (strtolower($type) == 'management') {
                $query->where('job_group_id', $jgroup->id);
            } else {
                $query->where('job_group_id', $jgroup->id);
            }

            $employees = $query->get();

            Log::info('Employee query executed', [
                'type' => $type,
                'job_group_id' => $jgroup->id,
                'end_date' => $end,
                'employee_count' => $employees->count(),
                'organization_id' => Auth::user()->organization_id
            ]);

            return $employees;
        } catch (Exception $e) {
            Log::error('Error retrieving employees', [
                'type' => $type,
                'job_group_id' => $jgroup->id,
                'error' => $e->getMessage(),
                'organization_id' => Auth::user()->organization_id
            ]);
            return collect();
        }
    }


    private function processMainPayroll($employees, $period)
    {
        $processedCount = 0;
        $errorCount = 0;

        Log::info('Starting main payroll processing', [
            'employee_count' => $employees->count(),
            'period' => $period
        ]);

        foreach ($employees as $employee) {
            try {
                $organizationId = Auth::user()->organization_id;

                // Check for existing payroll records
                $existingPayroll = Payroll::where('organization_id', $organizationId)
                    ->where('financial_month_year', $period)
                    ->where('employee_id', $employee->id)
                ->get();

                Log::debug('Checking existing payroll', [
                    'employee_id' => $employee->id,
                    'existing_count' => $existingPayroll->count()
                ]);

                // Delete existing records if any
                if ($existingPayroll->count() > 0) {
                    foreach ($existingPayroll as $payroll) {
                        $payroll->delete();
                }
                    Log::info('Deleted existing payroll records', [
                        'employee_id' => $employee->id,
                        'deleted_count' => $existingPayroll->count()
                    ]);
            }

                // Create new payroll record
                $payroll = new Payroll;
                $payroll->employee_id = $employee->id;
                $payroll->employeeId = $employee->personal_file_number;
                $payroll->user_id = Auth::user()->id;
                $payroll->basic_pay = Payroll::basicpay($employee->id, $period);
                $payroll->earning_amount = Payroll::total_benefits($employee->id, $period);
                $payroll->taxable_income = Payroll::taxablePay($employee->id, $period);
                $payroll->gross_tax = Payroll::totalTax($employee->id, $period);
                $payroll->paye = Payroll::tax($employee->id, $period);
                $payroll->relief = Payroll::personalRelief($employee->id, $period);
                $payroll->nssf_amount = Payroll::nssf($employee->id, $period);
                $payroll->nhif_amount = Payroll::nhif($employee->id, $period);
                $payroll->housing_levy = Payroll::housingLevy($employee->id, $period);
                $payroll->other_deductions = Payroll::deductionall($employee->id, $period);
                $payroll->total_deductions = Payroll::total_deductions($employee->id, $period);
                $payroll->net = Payroll::net($employee->id, $period);
                $payroll->financial_month_year = $period;
                $payroll->account_id = request('account');
                $payroll->process_type = request('type');
                $payroll->organization_id = $organizationId;

                $payroll->save();

                Log::debug('Payroll record created', [
                    'employee_id' => $employee->id,
                    'payroll_id' => $payroll->id,
                    'net_pay' => $payroll->net
                ]);

                // Send SMS notification
                $this->sendSMSNotification($employee, $payroll, $period);

                // Create email record
                $email = new Email();
                $email->employee_id = $employee->id;
                $email->organization_id = $organizationId;
                $email->save();

                $processedCount++;
            } catch (Exception $e) {
                $errorCount++;
                Log::error('Error processing payroll for employee', [
                    'employee_id' => $employee->id,
                    'employee_name' => $employee->first_name ?? 'Unknown',
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        Log::info('Main payroll processing completed', [
            'total_employees' => $employees->count(),
            'processed_successfully' => $processedCount,
            'errors' => $errorCount
        ]);
    }

    private function sendSMSNotification($employee, $payroll, $period)
    {
        try {
            $employeePhoneNo = $employee->telephone_mobile;
            $employeeName = $employee->first_name;
            $grossPay = $payroll->basic_pay + $payroll->earning_amount;
            $totalDeductions = $payroll->total_deductions;
            $net = $payroll->net;

            $this->smsLeopardFunction($employeePhoneNo, $employeeName, $net, $period, $grossPay, $totalDeductions);

            Log::debug('SMS notification sent', [
                'employee_id' => $employee->id,
                'phone' => $employeePhoneNo
            ]);
        } catch (Exception $e) {
            Log::warning('Failed to send SMS notification', [
                'employee_id' => $employee->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function processTransactionTables($start, $end, $jgroup, $isManagement, $employees)
    {
        Log::info('Starting transaction tables processing', [
            'is_management' => $isManagement,
            'job_group_id' => $jgroup->id,
            'start_date' => $start,
            'end_date' => $end,
            'employee_count' => $employees->count()
        ]);

        // Get array of employee IDs for filtering
        $employeeIds = $employees->pluck('id')->toArray();

        // Process each transaction type with employee IDs
        $this->processAllowances($start, $end, $jgroup, $isManagement, $employeeIds);
        $this->processNonTaxables($start, $end, $jgroup, $isManagement, $employeeIds);
        $this->processDeductions($start, $end, $jgroup, $isManagement, $employeeIds);
        $this->processPensions($start, $end, $jgroup, $isManagement, $employeeIds);
        $this->processEarnings($start, $end, $jgroup, $isManagement, $employeeIds);
        $this->processOvertimes($start, $end, $jgroup, $isManagement, $employeeIds);
        $this->processReliefs($start, $end, $jgroup, $isManagement, $employeeIds);

        Log::info('Transaction tables processing completed');
    }

    private function processAllowances($start, $end, $jgroup, $isManagement, $employeeIds)
    {
        try {
            Log::info('Processing allowances', [
                'is_management' => $isManagement,
                'job_group_id' => $jgroup->id,
                'employee_ids' => $employeeIds
            ]);

            $query = DB::table('x_employee_allowances')
                ->join('x_allowances', 'x_employee_allowances.allowance_id', '=', 'x_allowances.id')
                ->join('x_employee', 'x_employee_allowances.employee_id', '=', 'x_employee.id')
                ->where('instalments', '>', 0)
                ->where('in_employment', 'Y')
                ->whereDate('date_joined', '<=', $end)
                ->where('x_employee.organization_id', Auth::user()->organization_id)
                ->whereIn('x_employee.id', $employeeIds);

            $query->where(function ($q) use ($start) {
                $q->where(function ($subQ) use ($start) {
                    $subQ->where('formular', '=', 'Recurring')
                        ->where('first_day_month', '<=', $start);
                })
                    ->orWhere(function ($subQ) use ($start) {
                        $subQ->where('first_day_month', '<=', $start)
                            ->where('last_day_month', '>=', $start);
                    });
            });

            $allws = $query->select('x_employee.id as eid', 'x_employee_allowances.id as id', 'allowance_name', 'allowance_id', 'allowance_amount')->get();

            Log::info('Allowances query executed', [
                'allowances_found' => $allws->count(),
                'is_management' => $isManagement
            ]);

            if ($allws->count() > 0) {
                // Delete existing allowance transactions for this period
                $deletedCount = DB::table('x_transact_allowances')
                    ->where('organization_id', Auth::user()->organization_id)
                    ->where('financial_month_year', request('period'))
                    ->where('process_type', request('type'))
                    ->whereIn('employee_id', $employeeIds) // Only delete for processed employees
                    ->delete();

                Log::info('Deleted existing allowance transactions', ['deleted_count' => $deletedCount]);

                $insertedCount = 0;
                foreach ($allws as $allw) {
                    DB::table('x_transact_allowances')->insert([
                        'employee_id' => $allw->eid,
                        'employee_allowance_id' => $allw->id,
                        'organization_id' => Auth::user()->organization_id,
                        'allowance_name' => $allw->allowance_name,
                        'allowance_id' => $allw->allowance_id,
                        'allowance_amount' => $allw->allowance_amount,
                        'financial_month_year' => request('period'),
                        'process_type' => request('type'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $insertedCount++;
                }

                Log::info('Allowance transactions inserted', ['inserted_count' => $insertedCount]);

                // Decrement instalments for one-time and instalment allowances
                $decrementQuery = DB::table('x_employee_allowances')
                    ->join('x_employee', 'x_employee_allowances.employee_id', '=', 'x_employee.id')
                    ->where('x_employee.organization_id', Auth::user()->organization_id)
                    ->whereDate('date_joined', '<=', $end)
                    ->whereIn('x_employee.id', $employeeIds) // Only for processed employees
                    ->where(function ($query) {
                        $query->where('formular', '=', 'One Time')
                            ->orWhere('formular', '=', 'Instalments');
                    })
                    ->where('instalments', '>', 0);

                $decrementedCount = $decrementQuery->decrement('instalments');
                Log::info('Allowance instalments decremented', ['decremented_count' => $decrementedCount]);
            }
        } catch (Exception $e) {
            Log::error('Error processing allowances', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'is_management' => $isManagement
            ]);
        }
    }

    private function processNonTaxables($start, $end, $jgroup, $isManagement, $employeeIds)
    {
        try {
            Log::info('Processing non-taxables', [
                'is_management' => $isManagement,
                'job_group_id' => $jgroup->id,
                'employee_ids' => $employeeIds
            ]);

            $query = DB::table('x_employeenontaxables')
                ->join('x_nontaxables', 'x_employeenontaxables.nontaxable_id', '=', 'x_nontaxables.id')
                ->join('x_employee', 'x_employeenontaxables.employee_id', '=', 'x_employee.id')
                ->where('instalments', '>', 0)
                ->where('in_employment', 'Y')
                ->whereDate('date_joined', '<=', $end)
                ->where('x_employee.organization_id', Auth::user()->organization_id)
                ->whereIn('x_employee.id', $employeeIds);

            $query->where(function ($q) use ($start) {
                $q->where(function ($subQ) use ($start) {
                    $subQ->where('formular', '=', 'Recurring')
                        ->where('first_day_month', '<=', $start);
                })
                    ->orWhere(function ($subQ) use ($start) {
                        $subQ->where('first_day_month', '<=', $start)
                            ->where('last_day_month', '>=', $start);
                    });
            });

            $nontaxes = $query->select('x_employee.id as eid', 'x_employeenontaxables.id as id', 'name', 'nontaxable_id', 'nontaxable_amount')->get();

            Log::info('Non-taxables query executed', [
                'nontaxables_found' => $nontaxes->count(),
                'is_management' => $isManagement
            ]);

            if ($nontaxes->count() > 0) {
                // Delete existing nontaxable transactions for this period
                $deletedCount = DB::table('x_transact_nontaxables')
                    ->where('organization_id', Auth::user()->organization_id)
                    ->where('financial_month_year', request('period'))
                    ->where('process_type', request('type'))
                    ->whereIn('employee_id', $employeeIds) // Only delete for processed employees
                    ->delete();

                Log::info('Deleted existing nontaxable transactions', ['deleted_count' => $deletedCount]);

                $insertedCount = 0;
                foreach ($nontaxes as $nontax) {
                    DB::table('x_transact_nontaxables')->insert([
                        'employee_id' => $nontax->eid,
                        'organization_id' => Auth::user()->organization_id,
                        'employee_nontaxable_id' => $nontax->id,
                        'nontaxable_name' => $nontax->name,
                        'nontaxable_id' => $nontax->nontaxable_id,
                        'nontaxable_amount' => $nontax->nontaxable_amount,
                        'financial_month_year' => request('period'),
                        'process_type' => request('type'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $insertedCount++;
                }

                Log::info('Nontaxable transactions inserted', ['inserted_count' => $insertedCount]);

                // Decrement instalments
                $decrementQuery = DB::table('x_employeenontaxables')
                    ->join('x_employee', 'x_employeenontaxables.employee_id', '=', 'x_employee.id')
                    ->where('x_employee.organization_id', Auth::user()->organization_id)
                    ->whereDate('date_joined', '<=', $end)
                    ->whereIn('x_employee.id', $employeeIds) // Only for processed employees
                    ->where(function ($query) {
                        $query->where('formular', '=', 'One Time')
                            ->orWhere('formular', '=', 'Instalments');
                    })
                    ->where('instalments', '>', 0);

                $decrementedCount = $decrementQuery->decrement('instalments');
                Log::info('Nontaxable instalments decremented', ['decremented_count' => $decrementedCount]);
            }
        } catch (Exception $e) {
            Log::error('Error processing non-taxables', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'is_management' => $isManagement
            ]);
        }
    }

    private function processDeductions($start, $end, $jgroup, $isManagement, $employeeIds)
    {
        try {
            Log::info('Processing deductions', [
                'is_management' => $isManagement,
                'job_group_id' => $jgroup->id,
                'employee_ids' => $employeeIds
            ]);

            $query = DB::table('x_employee_deductions')
                ->join('x_deductions', 'x_employee_deductions.deduction_id', '=', 'x_deductions.id')
                ->join('x_employee', 'x_employee_deductions.employee_id', '=', 'x_employee.id')
                ->where('instalments', '>', 0)
                ->where('in_employment', 'Y')
                ->whereDate('date_joined', '<=', $end)
                ->where('x_employee.organization_id', Auth::user()->organization_id)
                ->whereIn('x_employee.id', $employeeIds);

            $query->where(function ($q) use ($start) {
                $q->where(function ($subQ) use ($start) {
                    $subQ->where('formular', '=', 'Recurring')
                        ->where('first_day_month', '<=', $start);
                })
                    ->orWhere(function ($subQ) use ($start) {
                        $subQ->where('first_day_month', '<=', $start)
                            ->where('last_day_month', '>=', $start);
                    });
            });

            $deds = $query->select('x_employee.id as eid', 'x_employee_deductions.id as id', 'deduction_name', 'deduction_id', 'formular', 'instalments', 'deduction_amount')->get();

            Log::info('Deductions query executed', [
                'deductions_found' => $deds->count(),
                'is_management' => $isManagement
            ]);

            if ($deds->count() > 0) {
                // Delete existing deduction transactions for this period
                $deletedCount = DB::table('x_transact_deductions')
                    ->where('organization_id', Auth::user()->organization_id)
                    ->where('financial_month_year', request('period'))
                    ->where('process_type', request('type'))
                    ->whereIn('employee_id', $employeeIds) // Only delete for processed employees
                    ->delete();

                Log::info('Deleted existing deduction transactions', ['deleted_count' => $deletedCount]);

                $insertedCount = 0;
                foreach ($deds as $ded) {
                    DB::table('x_transact_deductions')->insert([
                        'employee_id' => $ded->eid,
                        'organization_id' => Auth::user()->organization_id,
                        'employee_deduction_id' => $ded->id,
                        'deduction_name' => $ded->deduction_name,
                        'deduction_id' => $ded->deduction_id,
                        'deduction_amount' => $ded->deduction_amount,
                        'financial_month_year' => request('period'),
                        'process_type' => request('type'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $insertedCount++;
                }

                Log::info('Deduction transactions inserted', ['inserted_count' => $insertedCount]);

                // Decrement instalments
                $decrementQuery = DB::table('x_employee_deductions')
                    ->join('x_employee', 'x_employee_deductions.employee_id', '=', 'x_employee.id')
                    ->where('x_employee.organization_id', Auth::user()->organization_id)
                    ->whereDate('date_joined', '<=', $end)
                    ->whereIn('x_employee.id', $employeeIds) // Only for processed employees
                    ->where(function ($query) {
                        $query->where('formular', '=', 'One Time')
                            ->orWhere('formular', '=', 'Instalments');
                    })
                    ->where('instalments', '>', 0);

                $decrementedCount = $decrementQuery->decrement('instalments');
                Log::info('Deduction instalments decremented', ['decremented_count' => $decrementedCount]);
            }
        } catch (Exception $e) {
            Log::error('Error processing deductions', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'is_management' => $isManagement
            ]);
        }
    }

    private function processPensions($start, $end, $jgroup, $isManagement, $employeeIds)
    {
        try {
            Log::info('Processing pensions', [
                'is_management' => $isManagement,
                'employee_ids' => $employeeIds
            ]);

            $pensionTable = 'pensions';

            $query = DB::table($pensionTable)
                ->join('x_employee', $pensionTable . '.employee_id', '=', 'x_employee.id')
                ->where('in_employment', 'Y')
                ->whereDate('date_joined', '<=', $end)
                ->where('x_employee.organization_id', Auth::user()->organization_id)
                ->whereIn('x_employee.id', $employeeIds);

            $pensions = $query->get();

            Log::info('Pensions query executed', [
                'pensions_found' => $pensions->count(),
                'table_used' => $pensionTable,
                'is_management' => $isManagement
            ]);

            if ($pensions->count() > 0) {
                // Delete existing pension transactions for this period
                $deletedCount = DB::table('x_transact_pensions')
                    ->where('organization_id', Auth::user()->organization_id)
                    ->where('financial_month_year', request('period'))
                    ->whereIn('employee_id', $employeeIds) // Only delete for processed employees
                    ->delete();

                Log::info('Deleted existing pension transactions', ['deleted_count' => $deletedCount]);

                $part = explode("-", request('period'));
                $insertedCount = 0;

                foreach ($pensions as $pension) {
                    DB::table('x_transact_pensions')->insert([
                        'employee_id' => $pension->employee_id,
                        'organization_id' => Auth::user()->organization_id,
                        'employee_amount' => $pension->employee_contribution,
                        'employer_amount' => $pension->employer_contribution,
                        'employee_percentage' => $pension->employee_percentage,
                        'employer_percentage' => $pension->employer_percentage,
                        'financial_month_year' => request('period'),
                        'month' => $part[0],
                        'year' => $part[1],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $insertedCount++;
                }

                Log::info('Pension transactions inserted', ['inserted_count' => $insertedCount]);
            }
        } catch (Exception $e) {
            Log::error('Error processing pensions', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'is_management' => $isManagement
            ]);
        }
    }

    private function processEarnings($start, $end, $jgroup, $isManagement, $employeeIds)
    {
        try {
            Log::info('Processing earnings', [
                'is_management' => $isManagement,
                'job_group_id' => $jgroup->id,
                'employee_ids' => $employeeIds
            ]);

            $query = DB::table('x_earnings')
                ->join('x_employee', 'x_earnings.employee_id', '=', 'x_employee.id')
                ->join('x_earningsettings', 'x_earnings.earning_id', '=', 'x_earningsettings.id')
                ->where('instalments', '>', 0)
                ->where('in_employment', 'Y')
                ->whereDate('date_joined', '<=', $end)
                ->where('x_employee.organization_id', Auth::user()->organization_id)
                ->whereIn('x_employee.id', $employeeIds);

            $query->where(function ($q) use ($start) {
                $q->where(function ($subQ) use ($start) {
                    $subQ->where('formular', '=', 'Recurring')
                        ->where('first_day_month', '<=', $start);
                })
                    ->orWhere(function ($subQ) use ($start) {
                        $subQ->where('first_day_month', '<=', $start)
                            ->where('last_day_month', '>=', $start);
                    });
            });

            $earns = $query->select('x_earnings.employee_id', 'x_earnings.id as id', 'earning_name', 'earnings_amount', 'formular', 'instalments')->get();

            Log::info('Earnings query executed', [
                'earnings_found' => $earns->count(),
                'is_management' => $isManagement
            ]);

            if ($earns->count() > 0) {
                // Delete existing earning transactions for this period
                $deletedCount = DB::table('x_transact_earnings')
                    ->where('organization_id', Auth::user()->organization_id)
                    ->where('financial_month_year', request('period'))
                    ->where('process_type', request('type'))
                    ->whereIn('employee_id', $employeeIds) // Only delete for processed employees
                    ->delete();

                Log::info('Deleted existing earning transactions', ['deleted_count' => $deletedCount]);

                $insertedCount = 0;
                foreach ($earns as $earn) {
                    DB::table('x_transact_earnings')->insert([
                        'employee_id' => $earn->employee_id,
                        'earning_id' => $earn->id,
                        'organization_id' => Auth::user()->organization_id,
                        'earning_name' => $earn->earning_name,
                        'earning_amount' => $earn->earnings_amount,
                        'financial_month_year' => request('period'),
                        'process_type' => request('type'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $insertedCount++;
                }

                Log::info('Earning transactions inserted', ['inserted_count' => $insertedCount]);

                // Decrement instalments
                $decrementQuery = DB::table('x_earnings')
                    ->join('x_employee', 'x_earnings.employee_id', '=', 'x_employee.id')
                    ->where('x_employee.organization_id', Auth::user()->organization_id)
                    ->whereDate('date_joined', '<=', $end)
                    ->whereIn('x_employee.id', $employeeIds) // Only for processed employees
                    ->where(function ($query) {
                        $query->where('formular', '=', 'One Time')
                            ->orWhere('formular', '=', 'Instalments');
                    })
                    ->where('instalments', '>', 0);

                $decrementedCount = $decrementQuery->decrement('instalments');
                Log::info('Earning instalments decremented', ['decremented_count' => $decrementedCount]);
            }
        } catch (Exception $e) {
            Log::error('Error processing earnings', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'is_management' => $isManagement
            ]);
        }
    }

    private function processOvertimes($start, $end, $jgroup, $isManagement, $employeeIds)
    {
        try {
            Log::info('Processing overtimes', [
                'is_management' => $isManagement,
                'job_group_id' => $jgroup->id,
                'employee_ids' => $employeeIds
            ]);

            $query = DB::table('x_overtimes')
                ->join('x_employee', 'x_overtimes.employee_id', '=', 'x_employee.id')
                ->where('instalments', '>', 0)
                ->where('in_employment', 'Y')
                ->whereDate('date_joined', '<=', $end)
                ->where('x_employee.organization_id', Auth::user()->organization_id)
                ->whereIn('x_employee.id', $employeeIds);

            $query->where(function ($q) use ($start) {
                $q->where(function ($subQ) use ($start) {
                    $subQ->where('formular', '=', 'Recurring')
                        ->where('first_day_month', '<=', $start);
                })
                    ->orWhere(function ($subQ) use ($start) {
                        $subQ->where('first_day_month', '<=', $start)
                            ->where('last_day_month', '>=', $start);
                    });
            });

            $overtimes = $query->select('x_overtimes.employee_id', 'x_overtimes.id', 'x_overtimes.type', 'x_overtimes.period', 'x_overtimes.amount')->get();

            Log::info('Overtimes query executed', [
                'overtimes_found' => $overtimes->count(),
                'is_management' => $isManagement
            ]);

            if ($overtimes->count() > 0) {
                // Delete existing overtime transactions for this period
                $deletedCount = DB::table('x_transact_overtimes')
                    ->where('organization_id', Auth::user()->organization_id)
                    ->where('financial_month_year', request('period'))
                    ->where('process_type', request('type'))
                    ->whereIn('employee_id', $employeeIds) // Only delete for processed employees
                    ->delete();

                Log::info('Deleted existing overtime transactions', ['deleted_count' => $deletedCount]);

                $insertedCount = 0;
                foreach ($overtimes as $overtime) {
                    DB::table('x_transact_overtimes')->insert([
                        'employee_id' => $overtime->employee_id,
                        'organization_id' => Auth::user()->organization_id,
                        'overtime_type' => $overtime->type,
                        'overtime_id' => $overtime->id,
                        'overtime_period' => $overtime->period,
                        'overtime_amount' => $overtime->amount,
                        'financial_month_year' => request('period'),
                        'process_type' => request('type'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $insertedCount++;
                }

                Log::info('Overtime transactions inserted', ['inserted_count' => $insertedCount]);

                // Decrement instalments
                $decrementQuery = DB::table('x_overtimes')
                    ->join('x_employee', 'x_overtimes.employee_id', '=', 'x_employee.id')
                    ->where('x_employee.organization_id', Auth::user()->organization_id)
                    ->whereDate('date_joined', '<=', $end)
                    ->whereIn('x_employee.id', $employeeIds) // Only for processed employees
                    ->where(function ($query) {
                        $query->where('formular', '=', 'One Time')
                            ->orWhere('formular', '=', 'Instalments');
                    })
                    ->where('instalments', '>', 0);

                $decrementedCount = $decrementQuery->decrement('instalments');
                Log::info('Overtime instalments decremented', ['decremented_count' => $decrementedCount]);
            }
        } catch (Exception $e) {
            Log::error('Error processing overtimes', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'is_management' => $isManagement
            ]);
        }
    }

    private function processReliefs($start, $end, $jgroup, $isManagement, $employeeIds)
    {
        try {
            Log::info('Processing reliefs', [
                'is_management' => $isManagement,
                'job_group_id' => $jgroup->id,
                'employee_ids' => $employeeIds
            ]);

            $query = DB::table('x_employee_relief')
                ->join('x_relief', 'x_employee_relief.relief_id', '=', 'x_relief.id')
                ->join('x_employee', 'x_employee_relief.employee_id', '=', 'x_employee.id')
                ->where('in_employment', 'Y')
                ->whereDate('date_joined', '<=', $end)
                ->where('x_employee.organization_id', Auth::user()->organization_id)
                ->whereIn('x_employee.id', $employeeIds);

            $rels = $query->select('x_employee.id as eid', 'x_employee_relief.id as id', 'relief_name', 'relief_id', 'relief_amount')->get();

            Log::info('Reliefs query executed', [
                'reliefs_found' => $rels->count(),
                'is_management' => $isManagement
            ]);

            if ($rels->count() > 0) {
                // Delete existing relief transactions for this period
                $deletedCount = DB::table('x_transact_reliefs')
                    ->where('organization_id', Auth::user()->organization_id)
                    ->where('financial_month_year', request('period'))
                    ->where('process_type', request('type'))
                    ->whereIn('employee_id', $employeeIds) // Only delete for processed employees
                    ->delete();

                Log::info('Deleted existing relief transactions', ['deleted_count' => $deletedCount]);

                $insertedCount = 0;
                foreach ($rels as $rel) {
                    DB::table('x_transact_reliefs')->insert([
                        'employee_id' => $rel->eid,
                        'organization_id' => Auth::user()->organization_id,
                        'employee_relief_id' => $rel->id,
                        'relief_name' => $rel->relief_name,
                        'relief_id' => $rel->relief_id,
                        'relief_amount' => $rel->relief_amount,
                        'financial_month_year' => request('period'),
                        'process_type' => request('type'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $insertedCount++;
                }

                Log::info('Relief transactions inserted', ['inserted_count' => $insertedCount]);

                // Decrement instalments for reliefs
                $decrementQuery = DB::table('x_employee_relief')
                    ->join('x_employee', 'x_employee_relief.employee_id', '=', 'x_employee.id')
                    ->where('x_employee.organization_id', Auth::user()->organization_id)
                    ->whereDate('date_joined', '<=', $end)
                    ->whereIn('x_employee.id', $employeeIds) // Only for processed employees
                    ->where('instalments', '>', 0);

                $decrementedCount = $decrementQuery->decrement('instalments');
                Log::info('Relief instalments decremented', ['decremented_count' => $decrementedCount]);
            }
        } catch (Exception $e) {
            Log::error('Error processing reliefs', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'is_management' => $isManagement
            ]);
        }
    }


    /**
     * Display the specified branch.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $payroll = Payroll::findOrFail($id);

        return View::make('payroll.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $deduction = Deduction::find($id);

        return View::make('deductions.edit', compact('deduction'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update($id)
    {
        $deduction = Deduction::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Deduction::$rules, Deduction::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $deduction->deduction_name = request('name');
        $deduction->update();

        return Redirect::route('deductions.index');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        Deduction::destroy($id);

        return Redirect::route('deductions.index');
    }
}
