<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Traits\Encryptable;

class Citizenship extends Model
{
    protected $table = 'citizenships';


        /*protected $encryptable = [

            'allowance_name',
        ];*/

    public static $rules = [
        'name' => 'required'
    ];

    public static $messsages = array(
        'name.required' => 'Please insert citizenship type!',
    );

    // Don't forget to fill this array
    protected $fillable = ['name', 'organization_id'];


    public function employees()
    {

        return $this->hasMany(\App\Models\Employee::class);
    }

}
