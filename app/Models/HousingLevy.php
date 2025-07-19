<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HousingLevy extends Model
{
    public $table = "housing_levy";

    public static $rules = [
        'percentage' => 'required|numeric',
    ];

    public static $messages = array(
        'percentage.required' => 'Please insert percentage!',
    );

    protected $fillable = ['percentage'];

    public static function getCurrentRate()
    {
        $levy = self::first();
        return $levy ? $levy->percentage / 100 : 0.015; // Convert to decimal, fallback to 1.5%
    }
}