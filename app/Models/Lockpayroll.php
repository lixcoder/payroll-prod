<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Lockpayroll extends Model {

public $table = "x_lock_payroll";

public static $rules = [
		'userid' => 'required',
		'period' => 'required'
	];

public static $messages = array(
        'userid.required'=>'Please select user to rerun payroll!',
        'period.required'=>'Please select payroll period!',
    );

	// Don't forget to fill this array
	protected $fillable = [];

public static function checkAvailable($period){
		$period = Carbon::createFromFormat('m-Y', $period)->format('Y-m-d');

		$lock = Lockpayroll::where('period', $period)->first();
		if ($lock && $lock->user_id && $lock->authorized_by) {
			return 1;
		} else {
			return 0;
		}
}

public static function getUser($period){
		$period = Carbon::createFromFormat('m-Y', $period)->format('Y-m-d');

		$lock = Lockpayroll::where('period', $period)->first();
		if ($lock && $lock->authorized_by) {
			$user = User::find($lock->authorized_by);
			return $user->name;
		} else {
			return '';
		}
}

public static function getEmployee($period){
		$period = Carbon::createFromFormat('m-Y', $period)->format('Y-m-d');

		$lock = Lockpayroll::where('period', $period)->first();
		if ($lock && $lock->user_id) {
			$user = User::find($lock->user_id);
			return $user->name;
		} else {
			return '';
		}
}

}
