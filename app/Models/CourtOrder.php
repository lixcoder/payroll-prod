<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtOrder extends Model
{
    use HasFactory;

    protected $table = 'court_orders'; // matches your migration name

    protected $fillable = [
        'order_number',
        'description',
        'effective_date',
        'organization_id',
    ];

    public static $rules = [
        'order_number'   => 'required|string|max:255|unique:court_orders,order_number',
        'description'    => 'nullable|string',
        'effective_date' => 'required|date',
    ];

    public static $messages = [
        'order_number.required' => 'Court Order number is required.',
        'order_number.unique'   => 'This Court Order number already exists.',
        'effective_date.required' => 'Please provide an effective date.',
    ];
}
