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

        .organization-name {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
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

    <div class="organization-name">{{ $organization->name }}</div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th width="30">#</th>
                    <th>Staff No.</th>
                    <th>Employee Name</th>
                    <th>Code</th>
                    <th>Account No.</th>
                    <th class="amount-cell">Amount ({{ $currencies->shortname }})</th>
                    <th>Pay Method</th>
                    <th>DR Account</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($rems as $rem)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $rem->personal_file_number }}</td>
                        <td>
                            @if($rem->middle_name)
                                {{ $rem->first_name.' '.$rem->middle_name.' '.$rem->last_name }}
                            @else
                                {{ $rem->first_name.' '.$rem->last_name }}
                            @endif
                        </td>
                        <td>{{ $rem->bank_eft_code }}</td>
                        <td>{{ $rem->bank_account_number ?: '' }}</td>
                        <td class="amount-cell">{{ asMoney($rem->net) }}</td>
                        <td>Corporate Salary Transfer</td>
                        <td>{{ $organization->bank_account_number }}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach

                <tr class="total-row">
                    <td colspan="5" align="right"><strong>Total Remittances ({{ $currencies->shortname}}) :</strong></td>
                    <td class="amount-cell"><strong>{{ asMoney($total) }}</strong></td>
                    <td></td>
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