<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HousingLevy extends Model
{

    public $table = "housing_levy";

    public static $rules = [
        'percentage' => 'required',
    ];


    public static $messages = array(
        'percentage.required' => 'Please insert percentage!',
    );

    // Don't forget to fill this array
    protected $fillable = [];
}
