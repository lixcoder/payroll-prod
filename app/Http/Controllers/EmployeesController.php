<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ApiResponseTrait;
use App\Models\EmployeeProbation;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\License;
use App\Models\Audit;
use App\Models\EType;
use App\Models\Branch;
use App\Models\BBranch;
use App\Models\Currency;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Jobgroup;
use App\Models\JobTitle;
use App\Models\Property;
use App\Models\Appraisal;
use App\Models\Education;
use App\Models\Nextofkin;
use App\Models\Occurence;
use App\Models\Probation;
use App\Models\Department;
use App\Models\Mailsender;
use App\Models\Citizenship;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use App\Models\Employeebenefit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Validators\ValidationException;

use function PHPSTORM_META\type;

class EmployeesController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @return Response
     */

    use ApiResponseTrait;

    public function index()
    {

        $employees = Employee::getActiveEmployee();
        $probation = Employee::where('in_employment', '=', 'Y')->where('organization_id', Auth::user()->organization_id)->get();

        Audit::logaudit(now(), 'view', 'viewed employee list');

        return $this->respondWith(view('employees.index', compact('employees', 'probation')));
    }

    public function getEmployees()
    {
        return Employee::getActiveEmployee();
    }

    public function createcitizenship(Request $request)
    {
        $postcitizen = $request->all();
        $data = array('name' => $postcitizen['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('citizenships')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Citizenships', 'create', 'created: ' . $postcitizen['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createeducation(Request $request)
    {
        $posteducation = $request->all();
        $data = array('education_name' => $posteducation['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('education')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Educations', 'create', 'created: ' . $posteducation['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createjobtitle(Request $request)
    {
        $postjobtitle = $request->all();
        $data = array('job_title' => $postjobtitle['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_jobtitles')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Job Title', 'create', 'created: ' . $postjobtitle['name']);
            return $check;
        } else {
            return 1;
        }

    }
    public function createbank(Request $request)
    {
        $postbank = $request->all();
        $data = array('bank_name' => $postbank['name'],
            'bank_code' => $postbank['code'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('banks')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Banks', 'create', 'created: ' . $postbank['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createbankbranch(Request $request)
    {
        $postbankbranch = $request->all();
        //dd($postbankbranch);
        $data = array('bank_branch_name' => $postbankbranch['name'],
            'branch_code' => $postbankbranch['code'],
            'bank_id' => $postbankbranch['bid'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('bank_branches')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $postbankbranch['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createbranch(Request $request)
    {
        $postbranch = $request->all();
        $data = array('name' => $postbranch['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_branches')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $postbranch['name']);
            return $check;
        } else {
            return 1;
        }

    }


    public function createdepartment(Request $request)
    {
        $postdept = $request->all();
        $data = array('name' => $postdept['name'],
            'codes' => $postdept['code'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_departments')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $postdept['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function createtype(Request $request)
    {
        $posttype = $request->all();
        $data = array('employee_type_name' => $posttype['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_employee_type')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $posttype['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function creategroup(Request $request)
    {
        $postgroup = $request->all();
        $data = array(
            'job_group_name' => $postgroup['job_group_name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_job_group')->insertGetId($data);

        if ($check > 0) {
            $date = now();
            $user = Auth::user()->username;
            Audit::logaudit($date, $user, 'created: ' . $postgroup['name']);
            return $check;
        } else {
            return 1;
        }

    }

    /*
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $organization = Organization::find(Auth::user()->organization_id);

        $employees = count(Employee::where('organization_id', Auth::user()->organization_id)->get());
//        dd($employees);
        #echo "<pre>"; print_r($organization->licensed); echo "</pre>"; die;

        // Reduct and make changes when deploying // (Ian_Ray)

        // if(!(License::checkSubscription(Auth::user()->organization_id))){
        //     return View::make('employees.employeelimit');
        // }

        //  
        
        if (app()->environment('production') && !(License::checkSubscription(Auth::user()->organization_id))) {
            return View::make('employees.employeelimit');
        }
         else {
            try {$jgroups = Jobgroup::where('organization_id', Auth::user()->organization_id)->get();
                $currency = Currency::where('organization_id', Auth::user()->organization_id)->first();
                // $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();
//            dd($currency);
                $branches = Branch::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
                $departments = Department::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
                $jgroups = Jobgroup::where('organization_id', Auth::user()->organization_id)->get();
                $jobtitles = JobTitle::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
                $etypes = EType::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
                $banks = Bank::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
                $bbranches = BBranch::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
                $educations = Education::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
                $citizenships = Citizenship::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
                $pfn = 0;
                if (Employee::where('organization_id', Auth::user()->organization_id)->orderBy('id', 'DESC')->count() == 0) {
                    $pfn = 0;
                } else {
                    $pfn = Employee::where('organization_id', Auth::user()->organization_id)->orderBy('id', 'DESC')->pluck('personal_file_number');
                    $pfn = preg_replace('/\D/', '', $pfn);

                }
                //return $bbranches;
                return View::make('employees.create', compact('currency', 'citizenships', 'pfn', 'branches', 'departments', 'jobtitles', 'etypes', 'jgroups', 'banks', 'bbranches', 'educations'));
            }
            catch (\Exception $e){}
        }
    }

    /*
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // -------------------
        // VALIDATION
        // -------------------
        $rules = [
            'fname'      => 'required|string|max:255',
            'education'  => 'required|integer',
            'pin'        => 'nullable|unique:x_employee',
            'modep'      => 'required|in:mpesa,bank,cash,other',
        ];

        // Conditional rules for payment method
        switch ($request->modep) {
            case 'mpesa':
                $rules['telephone_mobile'] = 'required|digits_between:10,12|unique:x_employee';
                break;

            case 'bank':
                $rules['bank_account_number'] = 'required|unique:x_employee';
                $rules['bank_eft_code'] = 'required';
                $rules['swift_code'] = 'required|unique:x_employee';
                break;

            case 'cash':
            case 'other':
                // No extra rules
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $employee = new Employee;

            // -------------------
            // FILE UPLOADS
            // -------------------
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = time() . '-' . $file->getClientOriginalName();
                $file->move('public/uploads/employees/photo', $name);
                $employee->photo = $name;
            } else {
                $employee->photo = 'default_photo.png';
            }

            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $name = time() . '-' . $file->getClientOriginalName();
                $file->move('public/uploads/employees/signature/', $name);
                $employee->signature = $name;
            } else {
                $employee->signature = 'sign_av.jpg';
            }

            // -------------------
            // BASIC INFO
            // -------------------
            $employee->personal_file_number      = $request->get('personal_file_number');
            $employee->first_name                = $request->get('fname');
            $employee->last_name                 = $request->get('lname');
            $employee->middle_name               = $request->get('mname');
            $employee->identity_number           = $request->get('identity_number');
            $employee->military_id               = $request->get('military_id');
            $employee->passport_number           = $request->get('passport_number') ?: null;
            $employee->pin                       = $request->get('pin') ?: null;
            $employee->social_security_number    = $request->get('social_security_number') ?: null;
            $employee->hospital_insurance_number = $request->get('hospital_insurance_number') ?: null;
            $employee->work_permit_number        = $request->get('work_permit_number') ?: null;
            $employee->job_title                 = $request->get('jtitle');
            $employee->education_type_id         = $request->get('education') ?: 0;
            $employee->basic_pay                 = str_replace(',', '', $request->get('pay'));
            $employee->gender                    = $request->get('gender');
            $employee->marital_status            = $request->get('status');
            $employee->yob                        = $request->get('dob');
            $employee->citizenship_id            = $request->get('citizenship') ?: null;

            // -------------------
            // PAYMENT DETAILS
            // -------------------
            $employee->mode_of_payment       = $request->get('modep');
            $employee->bank_account_number   = $request->get('bank_account_number') ?: null;
            $employee->bank_eft_code         = $request->get('bank_eft_code') ?: null;
            $employee->swift_code            = $request->get('swift_code') ?: null;
            $employee->email_office          = $request->get('email_office') ?: null;
            $employee->email_personal        = $request->get('email_personal') ?: null;
            $employee->telephone_mobile      = $request->get('telephone_mobile') ?: null;

            // -------------------
            // ADDRESSES & DATES
            // -------------------
            $employee->postal_address        = $request->get('address');
            $employee->postal_zip            = $request->get('zip');
            $employee->date_joined           = date('Y-m-d', strtotime($request->get('djoined')));
            $employee->bank_id               = $request->get('bank_id') ?: null;
            $employee->bank_branch_id        = $request->get('bbranch_id') ?: null;
            $employee->branch_id             = $request->get('branch_id') ?: null;
            $employee->department_id         = $request->get('department_id') ?: null;
            $employee->job_group_id          = $request->get('jgroup_id') ?: null;
            $employee->type_id               = $request->get('type_id') ?: null;

            // -------------------
            // FLAGS
            // -------------------
            $employee->income_tax_applicable         = $request->get('i_tax') ? 1 : 0;
            $employee->income_tax_relief_applicable  = $request->get('i_tax_relief') ? 1 : 0;
            $employee->hospital_insurance_applicable = $request->get('a_nhif') ? 1 : 0;
            $employee->social_security_applicable    = $request->get('a_nssf') ? 1 : 0;
            $employee->custom_field1                 = $request->get('omode');
            $employee->organization_id               = Auth::user()->organization_id;
            $employee->start_date                    = Carbon::now();
            $employee->end_date                      = null;
            $employee->in_employment                 = $request->get('active') ? 'Y' : 'N';
            $employee->confirmed                     = $request->get('confirmed') ? 'Y' : 'N';

            // -------------------
            // SAVE EMPLOYEE
            // -------------------
            $employee->save();

            // -------------------
            // PROBATION
            // -------------------
            $probation = Probation::where('id', $request->probationPeriod)->pluck('period')->first();
            $months = (mb_substr($probation, 0, 1));

            $probationEmp = new EmployeeProbation();
            $probationEmp->employee_id     = $employee->id;
            $probationEmp->organization_id = Auth::user()->id;
            $probationEmp->start_date      = Carbon::now()->toDateString();
            $probationEmp->end_date        = Carbon::now()->addMonths($months);
            $probationEmp->save();

            // -------------------
            // NEXT OF KIN
            // -------------------
            if (!empty($request->get('kin_first_name')[0])) {
                for ($i = 0; $i < count($request->get('kin_first_name')); $i++) {
                    if (!empty($request->get('kin_first_name')[$i]) && !empty($request->get('kin_last_name')[$i])) {
                        $kin = new Nextofkin;
                        $kin->employee_id = $employee->id;
                        $kin->kin_name    = $request->get('kin_first_name')[$i] . ' ' . $request->get('kin_last_name')[$i] . ' ' . $request->get('kin_middle_name')[$i];
                        $kin->relation    = $request->get('relationship')[$i];
                        $kin->contact     = $request->get('contact')[$i];
                        $kin->id_number   = $request->get('id_number')[$i];
                        $kin->save();
                    }
                }
            }

            // -------------------
            // DOCUMENTS
            // -------------------
            $files = $request->file('path');
            $j = 0;
            if (!empty($request->get('doc_name')[0])) {
                foreach ($files as $file) {
                    if ($request->hasFile('path') && !empty($request->get('doc_name')[$j])) {
                        $document = new Document;
                        $document->employee_id = $employee->id;
                        $name = time() . '-' . $file->getClientOriginalName();
                        $file->move('public/uploads/employees/documents/', $name);
                        $extension = pathinfo($name, PATHINFO_EXTENSION);
                        $document->document_path = $name;
                        $document->document_name = $request->get('doc_name')[$j] . '.' . $extension;
                        $document->type = $request->get('type')[$j];
                        $document->save();
                        $j++;
                    }
                }
            }

            // -------------------
            // AUDIT LOG
            // -------------------
            Audit::logaudit(Carbon::now(), 'create', 'created: ' . $employee->personal_file_number . '-' . $employee->first_name . ' ' . $employee->last_name);

            return Redirect::route('employees.index')->withFlashMessage('Employee successfully created!');

        } catch (\Exception $e) {
            return Redirect::back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function getIndex()
    {
        return Redirect::route('employees.index')->withFlashMessage('Employee successfully created!');
    }

    public function exportTemplate()
    {
        return Excel::download(new EmployeeExport, 'EmployeeTemplate.xlsx');
    }

    /*
     * Import Employees
     * */
public function importEmployees(Request $request)
{
    Log::debug('Import request received: ' . json_encode($request->all()));
    $validator = Validator::make($request->all(), [
        'file' => 'required|mimes:csv,xlsx,xls|max:2048',
    ]);

    if ($validator->fails()) {
        Log::error('Validation failed: ' . json_encode($validator->errors()->all()));
        return redirect()->back()
            ->withErrors($validator) // Intelephense: $errors is available in the view via Laravel session
            ->withInput();
    }

    $import = new EmployeeImport();
    try {
        Excel::import($import, $request->file('file'));
        Audit::logaudit(now(), Auth::user()->username, 'import', 'Imported employees via file upload');

            $errors = $import->getErrors();
            if (!empty($errors)) {
                Log::warning('Import errors: ' . json_encode($errors));
                return redirect()->back()->with('import_errors', $errors);
        }

        return redirect()->back()->with('flash_message', 'Employees successfully uploaded!');
    } catch (ValidationException $e) {
        $failures = $e->failures();
        $errors = [];
        foreach ($failures as $failure) {
            $errors[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
        }
        Log::error('Validation exception: ' . json_encode($errors));
        return redirect()->back()->with('import_errors', $errors);
    } catch (\Exception $e) {
        Log::error('Employee import failed: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
        return redirect()->back()->with('error', 'Failed to import employees: ' . $e->getMessage());
    }
}

public function getBankBranches($bankId)
{
    try {
        $branches = BBranch::where('bank_id', $bankId)
            ->where(function ($query) {
                $query->whereNull('organization_id')
                      ->orWhere('organization_id', Auth::user()->organization_id);
            })
            ->get(['id', 'bank_branch_name']);

        return response()->json($branches);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function edit($id)
{
    $employee = Employee::find($id);
    $branches = Branch::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $departments = Department::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $jgroups = Jobgroup::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $jobtitles = JobTitle::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $etypes = EType::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $citizenships = Citizenship::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $contract = DB::table('x_employee')
        ->join('x_employee_type', 'x_employee.type_id', '=', 'x_employee_type.id')
        ->where('type_id', 2)
        ->first();
    $banks = Bank::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $bbranches = BBranch::where('bank_id', $employee->bank_id)->whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $educations = Education::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $kins = Nextofkin::where('employee_id', $id)->get();
    $docs = Document::where('employee_id', $id)->get();
    $countk = Nextofkin::where('employee_id', $id)->count();
    $countd = Document::where('employee_id', $id)->count();
    $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();

    return view('employees.edit', compact('currency', 'countk', 'countd', 'docs', 'kins', 'citizenships', 'contract', 'branches', 'educations', 'departments', 'etypes', 'jgroups', 'jobtitles', 'banks', 'bbranches', 'employee'));
}

    public function view($id)
    {
        $employee = Employee::find($id);
        $start_date  = $employee->end_date;
        $today = (new \DateTime(today()));
        $end = (new \DateTime($start_date));
        $interval = $today->diff($end);

        $appraisals = Appraisal::where('employee_id', $id)->get();


        $kins = Nextofkin::where('employee_id', $id)->get();

        $occurences = Occurence::where('employee_id', $id)->get();

        $properties = Property::where('employee_id', $id)->get();

        $documents = Document::where('employee_id', $id)->get();

        $benefits = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->get();

        $count = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->count();

        $organization = Organization::find(Auth::user()->organization_id);
        return View::make('employees.view', compact('employee', 'appraisals', 'kins', 'documents', 'occurences', 'properties', 'count', 'benefits'));

    }

public function update(Request $request, $id)
{
    Log::debug('Import update request: ' . json_encode($request->all()));

    $employee = Employee::findOrFail($id);

    // Map form field names to model column names used in DB
    $payload = [
        'personal_file_number'   => $request->input('personal_file_number'),
        'first_name'             => $request->input('fname'),
        'last_name'              => $request->input('lname'),
        'middle_name'            => $request->input('mname'),
        'identity_number'        => $request->input('identity_number'),
        'passport_number'        => $request->input('passport_number'),
        'yob'                    => $request->input('dob'),
        'marital_status'         => $request->input('status'),
        'citizenship_id'         => $request->input('citizenship'),
        'education_type_id'      => $request->input('education'),
        'gender'                 => $request->input('gender'),
        'pin'                    => $request->input('pin'),
        'social_security_number' => $request->input('social_security_number'),
        'hospital_insurance_number' => $request->input('hospital_insurance_number'),
        'in_employment'          => $request->has('active') ? 'Y' : 'N',
        'confirmed'              => $request->has('confirmed') ? 'Y' : 'N',
        'mode_of_payment'        => $request->input('modep'), // form uses modep
        'bank_id'                => $request->input('bank_id'),
        // form uses bbranch_id -> map to bank_branch_id column
        'bank_branch_id'         => $request->input('bbranch_id'),
        'bank_account_number'    => $request->input('bank_account_number'),
        'bank_eft_code'          => $request->input('bank_eft_code'),
        'swift_code'             => $request->input('swift_code'),
        'branch_id'              => $request->input('branch_id'),
        'department_id'          => $request->input('department_id'),
        'job_group_id'           => $request->input('jgroup_id'),
        'type_id'                => $request->input('type_id'),
        'start_date'             => $request->input('startdate'),
        'end_date'               => $request->input('enddate'),
        'work_permit_number'     => $request->input('work_permit_number'),
        'job_title'              => $request->input('jtitle'),
        'basic_pay'              => $request->input('pay') ? $request->input('pay') : $employee->basic_pay,
        'date_joined'            => $request->input('djoined'),
        'telephone_mobile'       => $request->input('telephone_mobile'),
        'email_office'           => $request->input('email_office'),
        'email_personal'         => $request->input('email_personal'),
        'postal_zip'             => $request->input('zip'),
        'postal_address'         => $request->input('address'),
    ];

    // If mode of payment is not Bank, remove bank fields so we don't try to write null into non-nullable columns
    if (strtolower((string)$payload['mode_of_payment']) !== 'bank') {
        unset(
            $payload['bank_id'],
            $payload['bank_branch_id'],
            $payload['bank_account_number'],
            $payload['bank_eft_code'],
            $payload['swift_code']
        );
    } else {
        // When Bank is selected, ensure branch id exists — provide clearer feedback
        if (empty($payload['bank_branch_id'])) {
            return redirect()->back()
                ->withErrors(['bank_branch_id' => 'Bank branch is required when payment mode is Bank.'])
                ->withInput();
        }
    }

    try {
        $employee->update(array_filter($payload, function ($v) { return $v !== null || $v === 0 || $v === '0'; }));
        Audit::logaudit(now(), Auth::user()->username, 'update', 'Updated employee ID '.$employee->id);
        return redirect()->back()->with('flash_message', 'Employee updated successfully!');
    } catch (\Exception $e) {
        Log::error('Employee update failed (ID '.$id.'): '.$e->getMessage());
        return redirect()->back()->with('error', 'Failed to update employee: '.$e->getMessage());
    }
}
}