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

        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .signature-table {
            width: 100%;
            margin-top: 30px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 100%;
        }

        .signature-label {
            text-align: center;
            padding-top: 5px;
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

    <div class="content">
        <table>
            <?php if($selBranch == 'All' && $selDept == 'All'){?>
                <tr>
                    <td width='120'><strong>Branch:</strong></td>
                    <td>All</td>
                </tr>
                <tr>
                    <td><strong>Department:</strong></td>
                    <td>All</td>
                </tr>
            <?php }else if($selBranch == 'All'){?>
                <tr>
                    <td><strong>Branch:</strong></td>
                    <td>All</td>
                </tr>
                <tr>
                    <td><strong>Department:</strong></td>
                    <td>{{$sels->name}}</td>
                </tr>
            <?php }else if($selDept == 'All'){?>
                <tr>
                    <td><strong>Branch:</strong></td>
                    <td>{{$sels->name}}</td>
                </tr>
                <tr>
                    <td><strong>Department:</strong></td>
                    <td>All</td>
                </tr>
            <?php }else if($selDept != 'Áll' && $selBranch != 'All'){?>
                <tr>
                    <td><strong>Branch:</strong></td>
                    <td>{{$selBr->name}}</td>
                </tr>
                <tr>
                    <td><strong>Department:</strong></td>
                    <td>{{$selDt->name}}</td>
                </tr>
            <?php } ?>
            <tr>
                <td><strong>Currency:</strong></td>
                <td>{{$currencies->first()->shortname ?? ''}}</td>
            </tr>
            <tr>
                <td><strong>Period:</strong></td>
                <td>{{$period}}</td>
            </tr>
        </table>

        <div class="title-section">
            <div class="report-title">PAYROLL SUMMARY REPORT</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="30">#</th>
                    <th>Payroll Number</th>
                    <th>Employee Name</th>
                    <th class="amount-cell">Basic Pay</th>
                    <th class="amount-cell">Allowance</th>
                    <th class="amount-cell">Gross Pay</th>
                    <th class="amount-cell">PAYE</th>
                    <th class="amount-cell">NSSF</th>
                    <th class="amount-cell">NHIF</th>
                    <th class="amount-cell">Other Deductions</th>
                    <th class="amount-cell">Total Deductions</th>
                    <th class="amount-cell">Net Pay</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($sums as $sum)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $sum->personal_file_number }}</td>
                        <td>
                            @if($sum->middle_name)
                                {{ $sum->first_name.' '.$sum->middle_name.' '.$sum->last_name }}
                            @else
                                {{ $sum->first_name.' '.$sum->last_name }}
                            @endif
                        </td>
                        <td class="amount-cell">{{ asMoney($sum->basic_pay) }}</td>
                        <td class="amount-cell">{{ asMoney($sum->earning_amount) }}</td>
                        <td class="amount-cell">{{ asMoney($sum->taxable_income) }}</td>
                        <td class="amount-cell">{{ asMoney($sum->paye) }}</td>
                        <td class="amount-cell">{{ asMoney($sum->nssf_amount) }}</td>
                        <td class="amount-cell">{{ asMoney($sum->nhif_amount) }}</td>
                        <td class="amount-cell">{{ asMoney($sum->other_deductions) }}</td>
                        <td class="amount-cell">{{ asMoney($sum->total_deductions) }}</td>
                        <td class="amount-cell">{{ asMoney($sum->net) }}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach

                <tr class="total-row">
                    <td colspan="3" align="right"><strong>Total:</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_pay) }}</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_earning) }}</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_gross) }}</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_paye) }}</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_nssf) }}</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_nhif) }}</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_others) }}</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_deds) }}</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_net) }}</strong></td>
                </tr>

                <tr class="total-row">
                    <td colspan="11" align="right"><strong>Total Net:</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total_net) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <table class="signature-table">
            <tr>
                <td width="120"><strong>Prepared By:</strong></td>
                <td><div class="signature-line"></div></td>
                <td width="150"><div class="signature-line"></div></td>
                <td width="150"><div class="signature-line"></div></td>
            </tr>
            <tr>
                <td></td>
                <td class="signature-label"><strong>Name</strong></td>
                <td class="signature-label"><strong>Signature</strong></td>
                <td class="signature-label"><strong>Date</strong></td>
            </tr>
            <tr><td colspan="4" height="20"></td></tr>
            
            <tr>
                <td><strong>Approved By:</strong></td>
                <td><div class="signature-line"></div></td>
                <td><div class="signature-line"></div></td>
                <td><div class="signature-line"></div></td>
            </tr>
            <tr>
                <td></td>
                <td class="signature-label"><strong>Name</strong></td>
                <td class="signature-label"><strong>Signature</strong></td>
                <td class="signature-label"><strong>Date</strong></td>
            </tr>
            <tr><td colspan="4" height="20"></td></tr>
            
            <tr>
                <td><strong>Authorized By:</strong></td>
                <td><div class="signature-line"></div></td>
                <td><div class="signature-line"></div></td>
                <td><div class="signature-line"></div></td>
            </tr>
            <tr>
                <td></td>
                <td class="signature-label"><strong>Name</strong></td>
                <td class="signature-label"><strong>Signature</strong></td>
                <td class="signature-label"><strong>Date</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="page-number"></div>
        <div>Printed on: {{ date('Y-m-d H:i:s') }}</div>
    </div>
</body>
</html>