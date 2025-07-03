<?php

namespace App\Calculations;

use Exception;

class KenyanPayrollCalculator
{

    /**
     *Disclaimer: make data dynamic in future 
     */
    // 2025 PAYE Tax Bands (KRA Official Rates)
    private $payeBands = [
        ['upper' => 24000,    'rate' => 0.10],   // First 24,000
        ['upper' => 32333,    'rate' => 0.25],   // Next 8,333
        ['upper' => 500000,   'rate' => 0.30],   // Next 467,667
        ['upper' => 800000,   'rate' => 0.325],  // Next 300,000
        ['upper' => PHP_FLOAT_MAX, 'rate' => 0.35]
    ];

    // 2025 Constants
    private $personalRelief = 2400;
    private $shifRate = 0.0275;
    private $shifMin = 300;
    private $nssfLEL = 8000;
    private $nssfUEL = 72000;
    private $nssfRate1 = 0.06;
    private $nssfRate2 = 0.06;
    private $housingLevyRate = 0.015;

    public function calculatePayroll($data)
    {
        try {
            $gross = $this->validateInput($data['gross'] ?? 0, 'Gross salary');

            // Calculate deductions
            $nssf = $this->calculateNSSF($gross);
            $shif = $this->calculateSHIF($gross);
            $housingLevy = $this->calculateHousingLevy($gross);

            // Calculate PAYE (NSSF, SHIF & HOUSING LEVY reduce taxable income)
            $taxableIncome = max($gross - $nssf['total'] - $shif - $housingLevy, 0);
            $paye = $this->calculatePAYE($taxableIncome);

            // Total deductions
            $totalDeductions = $paye + $nssf['total'] + $shif + $housingLevy;

            return [
                'gross_salary' => $gross,
                'deductions' => [
                    'paye' => $paye,
                    'nssf' => $nssf,
                    'shif' => $shif,
                    'housing_levy' => $housingLevy,
                    'total_deductions' => $totalDeductions
                ],
                'tax_details' => [
                    'taxable_income' => $taxableIncome,
                    'personal_relief' => $this->personalRelief
                ],
                'net_salary' => $gross - $totalDeductions
            ];
        } catch (Exception $e) {
            throw new Exception('Calculation error: ' . $e->getMessage());
        }
    }

    public function calculateFromNetPay($netPay, $data = [])
    {
        try {
            $netPay = $this->validateInput($netPay, 'Net Pay');

            // Binary search to find gross pay
            $tolerance = 0.01; // Precision in KES
            $low = $netPay;
            $high = $netPay * 3; // Increased upper bound for better coverage
            $gross = null;
            $maxIterations = 1000;
            $iterations = 0;

            // Ensure we have a reasonable upper bound
            while ($iterations < $maxIterations) {
                $testGross = $high;
                $testResult = $this->calculatePayroll(['gross' => $testGross]);

                if ($testResult['net_salary'] >= $netPay) {
                    break; // Found a good upper bound
                }

                $high *= 2; // Double the upper bound
                $iterations++;

                if ($iterations > 10) { // Prevent infinite loop
                    break;
                }
            }

            // Reset iterations for binary search
            $iterations = 0;

            while ($iterations < $maxIterations) {
                $mid = ($low + $high) / 2;

                // Calculate net pay for current guess
                $testResult = $this->calculatePayroll(['gross' => $mid]);
                $calculatedNet = $testResult['net_salary'];

                if (abs($calculatedNet - $netPay) <= $tolerance) {
                    $gross = $mid;
                    break;
                }

                if ($calculatedNet < $netPay) {
                    $low = $mid;
                } else {
                    $high = $mid;
                }

                $iterations++;
            }

            if ($gross === null) {
                throw new Exception("Could not calculate gross pay from net pay. Please try a different amount.");
            }

            // Return full payroll details using the calculated gross
            return $this->calculatePayroll(['gross' => $gross]);
        } catch (Exception $e) {
            throw new Exception('Net-to-gross calculation error: ' . $e->getMessage());
        }
    }

    private function calculateNSSF($gross)
    {
        $contributionBase = max(min($gross, $this->nssfUEL), $this->nssfLEL);
        return [
            'tier1' => $this->nssfLEL * $this->nssfRate1,
            'tier2' => ($contributionBase - $this->nssfLEL) * $this->nssfRate2,
            'total' => $contributionBase * $this->nssfRate1
        ];
    }

    private function calculatePAYE($taxableIncome)
    {
        $tax = 0;
        $remaining = $taxableIncome;
        $prevUpper = 0;

        foreach ($this->payeBands as $band) {
            $bandWidth = $band['upper'] - $prevUpper;
            $taxableInBand = min($remaining, $bandWidth);
            $tax += $taxableInBand * $band['rate'];
            $remaining -= $taxableInBand;
            $prevUpper = $band['upper'];
            if ($remaining <= 0) break;
        }

        return max($tax - $this->personalRelief, 0);
    }

    private function calculateSHIF($gross)
    {
        return floor(max($gross * $this->shifRate, $this->shifMin));
    }

    private function calculateHousingLevy($gross)
    {
        return floor($gross * $this->housingLevyRate);
    }

    private function validateInput($value, $field)
    {
        $num = floatval($value);
        if ($num < 0) throw new Exception("$field cannot be negative");
        return $num;
    }

    // Helper methods for backward compatibility with your current UI
    public function asMoney($value)
    {
        return number_format($value, 2);
    }
}
