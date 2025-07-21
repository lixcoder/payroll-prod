<?php
// App/Models/PayeRate.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PayeRate extends Model
{
    public $table = "paye";

    public static $rules = [
        'income_from' => 'required|numeric',
        'income_to' => 'required|numeric',
        'percentage' => 'required|numeric',
    ];
    
    public static $messages = array(
        'income_from.required' => 'Please insert income from amount!',
        'income_to.required' => 'Please insert income to amount!',
        'percentage.required' => 'Please insert percentage!',
    );

    protected $fillable = ['income_from', 'income_to', 'percentage'];

    public static function getTaxBands()
    {
        return self::orderBy('income_from')->get()->map(function ($rate) {
            return [
                'upper' => $rate->income_to,
                'rate' => $rate->percentage / 100 // Convert percentage to decimal
            ];
        })->toArray();
    }
}