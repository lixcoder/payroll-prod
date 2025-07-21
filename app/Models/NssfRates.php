<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class NssfRates extends Model
{
    public $table = "x_social_security";

    public static $rules = [
        'lower_earnings_limit' => 'required|numeric',
        'upper_earnings_limit' => 'required|numeric',
        'rate_tier1' => 'required|numeric',
        'rate_tier2' => 'required|numeric',
    ];

    public static $messages = array(
        'lower_earnings_limit.required' => 'Please insert lower earnings limit!',
        'upper_earnings_limit.required' => 'Please insert upper earnings limit!',
        'rate_tier1.required' => 'Please insert rate tier 1!',
        'rate_tier2.required' => 'Please insert rate tier 2!',
    );

    protected $fillable = ['lower_earnings_limit', 'upper_earnings_limit', 'rate_tier1', 'rate_tier2'];

    public static function getCurrentRates()
    {
        $rates = self::first();
        return [
            'lel' => $rates ? $rates->lower_earnings_limit : 8000,
            'uel' => $rates ? $rates->upper_earnings_limit : 72000,
            'rate1' => $rates ? $rates->rate_tier1 / 100 : 0.06, // Convert to decimal
            'rate2' => $rates ? $rates->rate_tier2 / 100 : 0.06
        ];
    }
}