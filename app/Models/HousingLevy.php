<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HousingLevy extends Model
{
    protected $table = "housing_levy";

    protected $fillable = ['employee_rate','employer_rate','organization_id'];

    public static $rules = [
        'employee_rate' => 'required|numeric|min:0',
        'employer_rate' => 'required|numeric|min:0',
    ];

    public static $messages = [
        'employee_rate.required' => 'Please insert employee percentage!',
        'employer_rate.required' => 'Please insert employer percentage!',
    ];

    public static function getCurrentRate()
    {
        $levy = self::first();

        if (! $levy) {
            return 0; // fallback if no rates found
        }

        // Sum both employee and employer rates and convert to decimal
        return ($levy->employee_rate + $levy->employer_rate) / 100;
    }
}
