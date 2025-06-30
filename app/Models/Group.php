<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'x_groups';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // Add your validation rules here
    public static $rules = [
        'name' => 'required|string|max:255',
    ];

    // Don't forget to fill this array
    protected $fillable = [
        'name', 'description', 'organization_id',
    ];

    // public function members()
    // {

    //     return $this->hasMany('Member');
    // }

}
