<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeCourtOrder extends Model
{
    protected $table = "employee_court_orders";

    protected $fillable = [
        'employee_id',
        'court_order_id',
        'deduction_type',
        'deduction_value',
        'max_deduction',
        'apply_on',
        'start_date',
        'end_date',
        'organization_id'
    ];

    public static $rules = [
        'employee_id'     => 'required|exists:x_employee,id',
        'court_order_id'  => 'required|exists:court_orders,id',
        'deduction_type'  => 'required|in:fixed,percentage',
        'deduction_value' => 'required|numeric|min:0',
        'max_deduction'   => 'nullable|numeric|min:0',
        'apply_on'        => 'required|in:gross,net',
    ];

    public static $messages = [
        'deduction_value.required' => 'Please enter the deduction value',
        'deduction_value.numeric'  => 'Deduction value must be numeric',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function courtOrder()
    {
        return $this->belongsTo(CourtOrder::class);
    }
}
