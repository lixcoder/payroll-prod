<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobgroup extends Model
{
    protected $table = 'x_job_group';

    protected $fillable = [
        'job_group_name', 'organization_id',
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
    ];

    public static $messages = [
        'name.required' => 'Please insert job group name!',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'job_group_id');
    }

    public function employeebenefits()
    {
        return $this->hasMany(Employeebenefit::class, 'jobgroup_id');
    }
}