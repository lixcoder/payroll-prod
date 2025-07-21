<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ShifRates extends Model
{
	public $table = "x_hospital_insurance";

	public static $rules = [
		'rate' => 'required|numeric',
		'minimum_amount' => 'required|numeric',
	];

	public static $messages = array(
		'rate.required' => 'Please insert rate!',
		'minimum_amount.required' => 'Please insert minimum amount!',
    );

	protected $fillable = ['rate', 'minimum_amount'];

	public static function getCurrentRates()
	{
		$rates = self::first();
		return [
			'rate' => $rates ? $rates->rate / 100 : 0.0275, // Convert to decimal, fallback to 2.75%
			'minimum' => $rates ? $rates->minimum_amount : 300
		];
	}
}