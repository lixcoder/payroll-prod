<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'description',
        'effective_date',
        'end_date',
        'order_type',
        'amount',
        'percentage',
        'apply_on',
        'organization_id',
    ];

    public static $rules = [
        'order_number'   => 'required|unique:court_orders,order_number',
        'description'    => 'required|string',
        'effective_date' => 'required|date',
        'end_date'       => 'nullable|date|after_or_equal:effective_date',
        'order_type'     => 'required|in:fixed,percentage',
        'amount'         => 'nullable|numeric|min:0',
        'percentage'     => 'nullable|numeric|min:0|max:100',
        'apply_on'       => 'required|in:gross,net',
    ];

    public static $messages = [
        'order_number.required'   => 'Order number is required',
        'order_number.unique'     => 'This order number is already taken',
        'description.required'    => 'Description is required',
        'effective_date.required' => 'Effective date is required',
        'order_type.required'     => 'Please select the order type',
    ];
}
