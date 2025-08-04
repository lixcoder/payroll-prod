<?php
function asMoney($value) {
    return number_format($value, 2);
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        * {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        body {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 20px;
        }

        th, td {
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .header {
            position: relative;
            text-align: center;
            margin-bottom: 20px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .header-text {
            text-align: center;
            flex-grow: 1;
        }

        .logo {
            max-width: 120px;
            max-height: 80px;
            margin-right: 20px;
        }

        .title-section {
            text-align: center;
            margin: 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
        }

        .period-info {
            margin-bottom: 5px;
            font-style: italic;
        }

        .footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        .content {
            padding: 0 10px;
        }

        .amount-cell {
            text-align: right;
            font-family: monospace;
        }

        .percentage-cell {
            text-align: center;
        }

        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        @page {
            margin: 100px 25px 70px 25px;
        }

        .page-number:after {
            content: "Page " counter(page);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            @if($organization->logo && file_exists(public_path('uploads/logo/'.$organization->logo)))
                <img class="logo" src="{{ public_path('uploads/logo/'.$organization->logo) }}" alt="logo">
            @endif
            <div class="header-text">
                <strong style="font-size: 16px;">{{ strtoupper($organization->name) }}</strong><br>
                {{ $organization->address }}<br>
                Phone: {{ $organization->phone }} | 
                Email: {{ $organization->email }}<br>
                {{ $organization->website }}
            </div>
        </div>
    </div>

    <div class="title-section">
        @if($type == 'All')
            <div class="report-title">PENSION CONTRIBUTIONS REPORT</div>
        @else
            <div class="report-title">PENSION CONTRIBUTIONS REPORT FOR {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name }}</div>
        @endif
        <div class="period-info">Period: {{ $period }}</div>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th width="30">#</th>
                    <th>Year</th>
                    <th>Month</th>
                    @if($type == 'All')
                        <th>Employee</th>
                    @endif
                    <th class="amount-cell">Employee Contribution ({{ $currencies->first()->shortname ?? '' }})</th>
                    <th class="percentage-cell">Employee %</th>
                    <th class="amount-cell">Employer Contribution ({{ $currencies->first()->shortname ?? '' }})</th>
                    <th class="percentage-cell">Employer %</th>
                    <th class="amount-cell">Interest</th>
                    <th class="amount-cell">Monthly Total</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; $totalamount = 0; $total_interest = 0; ?>
                @foreach($pensions as $ded)
                    <?php 
                    $current_interest = App\Models\Pensioninterest::getTransactInterest($ded->employee_id, $ded->financial_month_year);
                    $totalamount += $ded->employee_amount + $ded->employer_amount + $current_interest;
                    $total_interest += $current_interest;
                    ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $ded->year }}</td>
                        <td>{{ date('F', strtotime(date("Y") ."-". $ded->month."-01")) }}</td>
                        @if($type == 'All')
                            <td>
                                {{ $ded->personal_file_number.' : '.$ded->first_name }}
                                @if($ded->middle_name)
                                    {{ ' '.$ded->middle_name }}
                                @endif
                                {{ ' '.$ded->last_name }}
                            </td>
                        @endif
                        <td class="amount-cell">{{ asMoney($ded->employee_amount) }}</td>
                        <td class="percentage-cell">{{ asMoney($ded->employee_percentage) }}</td>
                        <td class="amount-cell">{{ asMoney($ded->employer_amount) }}</td>
                        <td class="percentage-cell">{{ asMoney($ded->employer_percentage) }}</td>
                        <td class="amount-cell">{{ asMoney($current_interest) }}</td>
                        <td class="amount-cell">{{ asMoney($ded->employee_amount + $ded->employer_amount + $current_interest) }}</td>
                        <td>{{ App\Models\Pensioninterest::getTransactComment($ded->employee_id, $ded->financial_month_year) }}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach

                <tr class="total-row">
                    @if($type == 'All')
                        <td colspan="4" align="right"><strong>Total</strong></td>
                    @else
                        <td colspan="3" align="right"><strong>Total</strong></td>
                    @endif
                    <td class="amount-cell"><strong>{{ asMoney($total->total_employee) }}</strong></td>
                    <td></td>
                    <td class="amount-cell"><strong>{{ asMoney($total->total_employer) }}</strong></td>
                    <td></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_interest) }}</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($totalamount) }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="page-number"></div>
        <div>Printed on: {{ date('Y-m-d H:i:s') }}</div>
    </div>
</body>
</html>