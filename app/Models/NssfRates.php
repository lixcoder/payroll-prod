<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NssfRates extends Model
{

    public $table = "x_social_security";

    public static $rules = [
        'employee_contribution' => 'required',
        'employer_contribution' => 'required',
        'total_contribution'=> 'required',
        'max_employee_nssf' => 'required',
        'max_employer_nssf' => 'required',
        'nssf_lower_earning' => 'required',
        'nssf_upper_earning' => 'required',
        'employer_nssf_upper_earning'=>'required',
    ];


    public static $messages = array(
        'employee_contribution.required' => 'Please insert employee_contribution!',
        'employer_contribution.required' => 'Please insert employer_contribution!',
        'total_contribution.required' => 'Please insert max_employer_nssf!',
        'max_employee_nssf.required' => 'Please insert max_employer_nssf!',
        'max_employer_nssf.required' => 'Please insert max_employer_nssf!',
        'nssf_lower_earning.required' => 'Please insert nssf_lower_earning!',
        'nssf_upper_earning.required' => 'Please insert nssf_upper_earning!',
        'employer_nssf_upper_earning' => 'Please insert employer_nssf_upper_earning!',
        'employer_nssf_upper_earning' => 'Please insert employer_nssf_upper_earning!',
        'graduated_scale' => 'Please insert graduated_scale!',
    );

    // Don't forget to fill this array
    protected $fillable = [];
    

}
