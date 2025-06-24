<?php
namespace App\Imports;

use App\Models\Employee;
use App\Models\Jobgroup;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;

class EmployeeImport implements ToModel, WithStartRow, WithValidation, SkipsOnError, WithEvents
{
    protected $pfn_counter;
    protected $errors = [];

    public function __construct()
    {
        $this->pfn_counter = Employee::max('personal_file_number')
            ? (int)preg_replace('/[^0-9]/', '', Employee::max('personal_file_number')) + 1
            : 1;
        Log::info('EmployeeImport initialized with pfn_counter: ' . $this->pfn_counter);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $row_count = Employee::count() + 1;
        Log::debug('Processing row #' . $row_count . ': ' . json_encode($row));

        if (!Auth::check()) {
            Log::error('No authenticated user during import for row #' . $row_count);
            return null;
        }

        $job_group_id = Jobgroup::where('organization_id', Auth::user()->organization_id)->pluck('id')->first();
        if (!$job_group_id) {
            Log::error('No job group found for row #' . $row_count . '. Ensure a job group exists for organization ID: ' . Auth::user()->organization_id);
            return null;
        }

        $organization = Organization::find(Auth::user()->organization_id);
        if (!$organization) {
            Log::error('Organization not found for ID: ' . Auth::user()->organization_id . ' in row #' . $row_count);
            return null;
        }

        $str = strtoupper($organization->name[0] . '.');
        $pfn = str_pad($this->pfn_counter++, 6, '0', STR_PAD_LEFT);

        $employee = new Employee([
            'personal_file_number' => $str . $pfn,
            'first_name' => $row[0] ?? '',
            'last_name' => $row[1] ?? '',
            'email_office' => $row[2] ?? null,
            'basic_pay' => $row[3] ?? 0,
            'pin' => $row[4] ?? null,
            'social_security_number' => $row[5] ?? null,
            'identity_number' => $row[6] ?? null,
            'hospital_insurance_number' => $row[7] ?? null,
            'gender' => $row[8] ?? '',
            'mode_of_payment' => $row[9] ?? '',
            'bank_account_number' => $row[10] ?? null,
            'organization_id' => Auth::user()->organization_id,
            'job_group_id' => $job_group_id,
            'in_employment' => 'Y',
            'confirmed' => 'N',
        ]);

        Log::info('Created employee model for row #' . $row_count . ': ' . json_encode($employee->toArray()));

        try {
            $employee->save();
            Log::info('Employee saved successfully for row #' . $row_count . ': ID ' . $employee->id);
        } catch (\Exception $e) {
            Log::error('Failed to save employee for row #' . $row_count . ': ' . $e->getMessage() . ' | Validation Errors: ' . ($employee->errors() ?? 'No validation errors'));
            $this->errors[] = 'Row ' . $row_count . ': Failed to save employee. Reason: ' . $e->getMessage();
            return null;
        }

        return $employee;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|string|max:255',
            '1' => 'required|string|max:255',
            '2' => 'nullable|email|unique:x_employees,email_office',
            '3' => 'required|numeric|min:0',
            '4' => 'nullable|string|unique:x_employees,pin',
            '5' => 'nullable|string|unique:x_employees,social_security_number',
            '6' => 'nullable|string|unique:x_employees,identity_number',
            '7' => 'nullable|string|unique:x_employees,hospital_insurance_number',
            '8' => 'required|in:Male,Female,Other',
            '9' => 'required|in:Bank,Cash,Cheque',
            '10' => 'required_if:9,Bank|nullable|string|unique:x_employees,bank_account_number|regex:/^[0-9]+$/',
        ];
    }

    public function onError(\Throwable $e)
    {
        $row_count = Employee::count() + 1; // Approximate
        Log::error('Import error for row #' . $row_count . ': ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
        $this->errors[] = 'Row ' . $row_count . ': ' . $e->getMessage();
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                if (!empty($this->errors)) {
                    session()->flash('import_errors', $this->errors);
                }
            },
        ];
    }
}