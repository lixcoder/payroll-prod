<?php

namespace App\Calculations;

use Exception;
use App\Models\PayeRate;
use App\Models\ShifRates;
use App\Models\NssfRates;
use App\Models\HousingLevy;

class KenyanPayrollCalculator
{
    // Keep personal relief as static since you mentioned to leave it as is
    private $personalRelief = 2400;

    // Dynamic data will be fetched from database
    private $payeBands = [];
    private $shifRates = [];
    private $nssfRates = [];
    private $housingLevyRate = 0;

    public function __construct()
    {
        $this->loadRatesFromDatabase();
    }

    private function loadRatesFromDatabase()
    {
        try {
            // Load PAYE tax bands
            $this->payeBands = PayeRate::getTaxBands();

            // Load SHIF rates
            $this->shifRates = ShifRates::getCurrentRates();

            // Load NSSF rates
            $this->nssfRates = NssfRates::getCurrentRates();

            // Load Housing Levy rate
            $this->housingLevyRate = HousingLevy::getCurrentRate();
        } catch (Exception $e) {
            // Fallback to hardcoded values if database is not available
            $this->setFallbackRates();
        }
    }

    private function setFallbackRates()
    {
        // Fallback to original hardcoded values
        $this->payeBands = [
            ['upper' => 24000,    'rate' => 0.10],
            ['upper' => 32333,    'rate' => 0.25],
            ['upper' => 500000,   'rate' => 0.30],
            ['upper' => 800000,   'rate' => 0.325],
            ['upper' => PHP_FLOAT_MAX, 'rate' => 0.35]
        ];

        $this->shifRates = ['rate' => 0.0275, 'minimum' => 300];
        $this->nssfRates = ['lel' => 8000, 'uel' => 72000, 'rate1' => 0.06, 'rate2' => 0.06];
        $this->housingLevyRate = 0.015;
    }

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
            $tolerance = 0.01;
            $low = $netPay;
            $high = $netPay * 3;
            $gross = null;
            $maxIterations = 1000;
            $iterations = 0;

            // Ensure we have a reasonable upper bound
            while ($iterations < $maxIterations) {
                $testGross = $high;
                $testResult = $this->calculatePayroll(['gross' => $testGross]);

                if ($testResult['net_salary'] >= $netPay) {
                    break;
                }

                $high *= 2;
                $iterations++;

                if ($iterations > 10) {
                    break;
                }
            }

            $iterations = 0;

            while ($iterations < $maxIterations) {
                $mid = ($low + $high) / 2;

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

            return $this->calculatePayroll(['gross' => $gross]);
        } catch (Exception $e) {
            throw new Exception('Net-to-gross calculation error: ' . $e->getMessage());
        }
    }

    private function calculateNSSF($gross)
    {
        $lel = $this->nssfRates['lel'];
        $uel = $this->nssfRates['uel'];
        $rate1 = $this->nssfRates['rate1'];
        $rate2 = $this->nssfRates['rate2'];

        $contributionBase = max(min($gross, $uel), $lel);

        return [
            'tier1' => $lel * $rate1,
            'tier2' => ($contributionBase - $lel) * $rate2,
            'total' => $contributionBase * $rate1
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
        $rate = $this->shifRates['rate'];
        $minimum = $this->shifRates['minimum'];

        return floor(max($gross * $rate, $minimum));
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

    public function asMoney($value)
    {
        return number_format($value, 2);
    }

    // Method to refresh rates from database if needed
    public function refreshRates()
    {
        $this->loadRatesFromDatabase();
    }
}