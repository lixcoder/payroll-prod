<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all(); 
        return response()->json(['employees' => $employees], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'personal_file_number' => 'required|unique:x_employee,personal_file_number',
            'lname' => 'required',
            'fname' => 'required',
            'identity_number' => 'required|unique:x_employee,identity_number',
            'dob' => 'required',
            'gender' => 'required',
            'jgroup_id' => 'required',
            'type_id' => 'required',
            'pay' => 'required|regex:/^(\$?(?(?=\()(\())\d+(?:,\d+)?(?:\.\d+)?(?(2)\)))$/',
            'djoined' => 'required',
            'email_office' => 'required|email|unique:x_employee,email_office',
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        Employee::create($request->all());

        return response()->json(['message' => 'Employee created successfully'], 201);
    }
}
