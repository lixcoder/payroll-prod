<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip Monthly Report</title>
    <style type="text/css">
        * {
            font-family: "Helvetica Neue", Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #fff;
            padding: 10px;
        }

        .payslip-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto 20px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            page-break-after: always;
        }

        .header {
            padding: 15px;
            text-align: center;
            border-bottom: 2px solid #f0f0f0;
            background-color: #f9f9f9;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .logo {
            height: 50px;
            margin-right: 15px;
        }

        .organization-info {
            text-align: left;
        }

        .organization-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .period-title {
            font-weight: bold;
            font-size: 12px;
            margin-top: 5px;
            padding: 5px;
            background-color: #f0f0f0;
        }

        .payslip-content {
            padding: 15px;
        }

        .payslip-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .payslip-table th {
            background-color: #f5f5f5;
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }

        .payslip-table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }

        .amount-cell {
            text-align: right;
            font-family: monospace;
        }

        .section-title {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin: 20px 0 5px;
            width: 200px;
        }

        .signature-label {
            font-size: 10px;
            color: #666;
        }

        @media print {
            .payslip-container {
                box-shadow: none;
                border: none;
                margin: 0;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <?php
        use App\Models\Employee;
        use Illuminate\Support\Facades\Auth;
        
        if(request('employeeid') == 'All') {
            $empall = Employee::where('organization_id', Auth::user()->organization_id)->get();   
        } else {
            $empall = Employee::where('id', request('employeeid'))->get();
        }
    ?>

    @foreach($empall as $emp)
    <div class="payslip-container">
        <div class="header">
            <div class="header-content">
                <img class="logo" src="{{asset('/uploads/logo/sycum.jpeg')}}" alt="logo">
                <div class="organization-info">
                    <div class="organization-name">{{strtoupper($organization->name)}}</div>
                    <div>{{ $organization->phone}} | {{ $organization->website}}</div>
                    <div>{{ $organization->email}}</div>
                    <div>{{ nl2br($organization->address)}}</div>
                </div>
            </div>
            <div class="period-title">PAYSLIP FOR PERIOD: {{ $period }}</div>
        </div>

        <div class="payslip-content">
            <table class="payslip-table">
                <tr class="section-title">
                    <td colspan="2">EMPLOYEE DETAILS</td>
                </tr>
                <tr>
                    <td width="40%">Payroll Number:</td>
                    <td>{{$emp->personal_file_number}}</td>
                </tr>
                <tr>
                    <td>Employee Name:</td>
                    <td>
                        {{$emp->first_name}}
                        @if($emp->middle_name) {{' '.$emp->middle_name}} @endif
                        {{' '.$emp->last_name}}
                    </td>
                </tr>
                <tr>
                    <td>Identity Number:</td>
                    <td>{{$emp->identity_number}}</td>
                </tr>
                <tr>
                    <td>KRA Pin:</td>
                    <td>{{$emp->pin ?: 'N/A'}}</td>
                </tr>
                <tr>
                    <td>NSSF Number:</td>
                    <td>{{$emp->social_security_number ?: 'N/A'}}</td>
                </tr>
                <tr>
                    <td>NHIF Number:</td>
                    <td>{{$emp->hospital_insurance_number ?: 'N/A'}}</td>
                </tr>
            </table>

            <table class="payslip-table">
                <tr class="section-title">
                    <td colspan="2">EARNINGS</td>
                </tr>
                <tr>
                    <td>Basic Pay:</td>
                    <td class="amount-cell">{{ App\Models\Payroll::processedsalaries($emp->personal_file_number,$period) }}</td>
                </tr>

                @if(App\Models\Payroll::processedearningnames($emp->id,$period) != null)
                    @foreach(App\Models\Payroll::processedearnings($emp->id,$period) as $name => $amount)
                        <tr>
                            <td>{{ $name }}:</td>
                            <td class="amount-cell">{{ $amount }}</td>
                        </tr>
                    @endforeach
                @endif

                @if(App\Models\Payroll::processedovertimenames($emp->id,$period) != null)
                    @foreach(App\Models\Payroll::processedovertimes($emp->id,$period) as $name => $amount)
                        <tr>
                            <td>{{ $name }}:</td>
                            <td class="amount-cell">{{ $amount }}</td>
                        </tr>
                    @endforeach
                @endif

                <tr class="total-row">
                    <td><strong>Gross Pay:</strong></td>
                    <td class="amount-cell"><strong>{{ App\Models\Payroll::processedgrossincome($emp->personal_file_number,$period) }}</strong></td>
                </tr>
                <tr>
                    <td><strong>Taxable Pay:</strong></td>
                    <td class="amount-cell"><strong>{{ App\Models\Payroll::processedgross($emp->personal_file_number,$period) }}</strong></td>
                </tr>
            </table>

            <table class="payslip-table">
                <tr class="section-title">
                    <td colspan="2">ALLOWANCES</td>
                </tr>
                @if(App\Models\Payroll::processedallowancenames($emp->id,$period) != null)
                    @foreach(App\Models\Payroll::processedallowances($emp->id,$period) as $name => $amount)
                        <tr>
                            <td>{{ $name }}:</td>
                            <td class="amount-cell">{{ $amount }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="2">No allowances</td></tr>
                @endif
            </table>

            <table class="payslip-table">
                <tr class="section-title">
                    <td colspan="2">NON-TAXABLE ITEMS</td>
                </tr>
                @if(App\Models\Payroll::processednontaxnames($emp->id,$period) != null)
                    @foreach(App\Models\Payroll::processednontaxables($emp->id,$period) as $name => $amount)
                        <tr>
                            <td>{{ $name }}:</td>
                            <td class="amount-cell">{{ $amount }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="2">No non-taxable items</td></tr>
                @endif
            </table>

            <table class="payslip-table">
                <tr class="section-title">
                    <td colspan="2">TAX RELIEFS</td>
                </tr>
                @if(App\Models\Payroll::processedreliefnames($emp->id,$period) != null)
                    @foreach(App\Models\Payroll::processedreliefs($emp->id,$period) as $name => $amount)
                        <tr>
                            <td>{{ $name }}:</td>
                            <td class="amount-cell">{{ $amount }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="2">No tax reliefs</td></tr>
                @endif
                <tr>
                    <td>Gross Tax:</td>
                    <td class="amount-cell">{{ App\Models\Payroll::processedgrosstax($emp->personal_file_number,$period) }}</td>
                </tr>
                <tr>
                    <td>Personal Relief:</td>
                    <td class="amount-cell">{{ App\Models\Payroll::processedpersonalrelief($emp->personal_file_number,$period) }}</td>
                </tr>
            </table>

            <table class="payslip-table">
                <tr class="section-title">
                    <td colspan="2">DEDUCTIONS</td>
                </tr>
                <tr>
                    <td>PAYE:</td>
                    <td class="amount-cell">{{ App\Models\Payroll::processedpaye($emp->personal_file_number,$period) }}</td>
                </tr>
                <tr>
                    <td>NSSF:</td>
                    <td class="amount-cell">{{ App\Models\Payroll::processedNssf($emp->personal_file_number,$period) }}</td>
                </tr>
                <tr>
                    <td>NHIF:</td>
                    <td class="amount-cell">{{ App\Models\Payroll::processedNhif($emp->personal_file_number,$period) }}</td>
                </tr>
                <tr>
                    <td>Housing Levy:</td>
                    <td class="amount-cell">{{ App\Models\Payroll::processedLevy($emp->personal_file_number,$period) }}</td>
                </tr>
                <tr>
                    <td>Pension Contribution:</td>
                    <td class="amount-cell">{{ App\Models\Payroll::processedpensions($emp->personal_file_number,$period) }}</td>
                </tr>

                @if(App\Models\Payroll::processeddeductionnames($emp->id,$period) != null)
                    @foreach(App\Models\Payroll::processedDeductions($emp->id,$period) as $name => $amount)
                        <tr>
                            <td>{{ $name }}:</td>
                            <td class="amount-cell">{{ $amount }}</td>
                        </tr>
                    @endforeach
                @endif

                <tr class="total-row">
                    <td><strong>TOTAL DEDUCTIONS:</strong></td>
                    <td class="amount-cell"><strong>{{ App\Models\Payroll::processedtotaldeds($emp->id,$period) }}</strong></td>
                </tr>
            </table>

            <table class="payslip-table">
                <tr class="total-row">
                    <td><strong>NET PAY:</strong></td>
                    <td class="amount-cell"><strong>{{ App\Models\Payroll::processednet($emp->personal_file_number,$period) }}</strong></td>
                </tr>
            </table>

            <div class="signature-section">
                <p>I certify that the above information is correct and I have received the payment, in full and final settlement</p>
                
                <div style="margin-top: 30px;">
                    <div style="float: left; width: 33%;">
                        <div class="signature-line"></div>
                        <div class="signature-label">Employee Signature</div>
                    </div>
                    <div style="float: left; width: 33%;">
                        <div class="signature-line"></div>
                        <div class="signature-label">Employer Signature</div>
                    </div>
                    <div style="float: left; width: 33%;">
                        <div class="signature-line"></div>
                        <div class="signature-label">Date</div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</body>
</html>