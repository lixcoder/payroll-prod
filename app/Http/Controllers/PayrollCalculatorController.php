<?php

namespace App\Http\Controllers;

use App\Calculations\KenyanPayrollCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayrollCalculatorController extends Controller
{
    protected $calculator;

    public function __construct()
    {
        $this->calculator = new KenyanPayrollCalculator();
    }

    public function index()
    {
        // Get currency from your existing setup
        $currency = (object) ['shortname' => 'KES'];
        return view('payroll.payroll_calculator', compact('currency'));
    }

    public function showNet(Request $request)
    {
        try {
            // Parse the form data
            parse_str($request->input('formdata'), $formData);

            // Clean the gross input (remove commas and whitespace)
            $grossInput = str_replace([',', ' '], '', $formData['gross'] ?? '0');

            // Validate that it's a valid number
            if (!is_numeric($grossInput) || floatval($grossInput) <= 0) {
                return response()->json(['error' => 'Please enter a valid gross salary'], 422);
            }

            $gross = floatval($grossInput);
            $data = [
                'gross' => $gross,
            ];

            // Calculate payroll
            $result = $this->calculator->calculatePayroll($data);

            return response()->json([
                'gross' => $this->calculator->asMoney($result['gross_salary']),
                'paye' => $this->calculator->asMoney($result['deductions']['paye']),
                'nssf' => $this->calculator->asMoney($result['deductions']['nssf']['total']),
                'shif' => $this->calculator->asMoney($result['deductions']['shif']),
                'housing_levy' => $this->calculator->asMoney($result['deductions']['housing_levy']),
                'net' => $this->calculator->asMoney($result['net_salary'])
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showGross(Request $request)
    {
        try {
            // Parse the form data
            parse_str($request->input('formdata'), $formData);

            // Clean the net input (remove commas and whitespace)
            $netInput = str_replace([',', ' '], '', $formData['net1'] ?? '0');

            // Validate that it's a valid number
            if (!is_numeric($netInput) || floatval($netInput) <= 0) {
                return response()->json(['error' => 'Please enter a valid net salary'], 422);
            }

            $net = floatval($netInput);

            // Calculate gross from net - Fix: pass net pay directly, not in array
            $result = $this->calculator->calculateFromNetPay($net);

            return response()->json([
                'gross1' => $this->calculator->asMoney($result['gross_salary']),
                'paye1' => $this->calculator->asMoney($result['deductions']['paye']),
                'nssf1' => $this->calculator->asMoney($result['deductions']['nssf']['total']),
                'shif' => $this->calculator->asMoney($result['deductions']['shif']),
                'housing_levy1' => $this->calculator->asMoney($result['deductions']['housing_levy']),
                'netv' => $this->calculator->asMoney($result['net_salary'])
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
