<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeCourtOrder extends Model
{
    protected $table = 'employee_court_orders';

    protected $fillable = [
        'employee_id',
        'court_order_id',
        'amount',
        'start_date',
        'end_date',
        'organization_id'
    ];

    public static $rules = [
        'employee_id' => 'required',
        'court_order_id' => 'required',
        'amount' => 'required|numeric'
    ];

    public static $messages = [
        'employee_id.required' => 'Please select an employee',
        'court_order_id.required' => 'Please select a court order',
        'amount.required' => 'Please enter the deduction amount'
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
