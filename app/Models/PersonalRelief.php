<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalRelief extends Model
{
    public $table = "x_tax_relief";

    public static $rules = [
        'amount' => 'required|numeric|min:0',
    ];

    public static $messages = array(
        'amount.required' => 'Please insert relief amount!',
        'amount.numeric' => 'Relief amount must be a number!',
        'amount.min' => 'Relief amount cannot be negative!',
    );

    protected $fillable = ['amount', 'organization_id'];

    public static function getCurrentAmount()
    {
        $relief = self::first();
        return $relief ? $relief->amount : 2400; // Fallback to 2400 KES
    }
}
