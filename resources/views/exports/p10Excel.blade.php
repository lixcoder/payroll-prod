<table>
    <thead>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 16px; font-weight: bold;">
                Kenya Revenue Authority - P10 Form (Employer’s PAYE Return) - {{ $year }}
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: left;">
                Employer: {{ $organization->name }} | PIN: {{ $organization->tax_number_1 }}
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th>Employee Name</th>
            <th>PIN</th>
            <th>Gross Pay (Ksh)</th>
            <th>Taxable Pay (Ksh)</th>
            <th>PAYE (Ksh)</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1; $totalGross=0; $totalTaxable=0; $totalPaye=0; @endphp
        @foreach($employees as $employee)
            @php
                $transactions = $employee->transactions;
                $gross = $transactions->sum('basic_pay');
                $taxable = $transactions->sum('taxable_income');
                $paye = $transactions->sum('paye');
                $totalGross += $gross;
                $totalTaxable += $taxable;
                $totalPaye += $paye;
            @endphp
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $employee->first_name.' '.$employee->last_name }}</td>
                <td>{{ $employee->pin }}</td>
                <td>{{ number_format($gross, 2) }}</td>
                <td>{{ number_format($taxable, 2) }}</td>
                <td>{{ number_format($paye, 2) }}</td>
            </tr>
        @endforeach
        <tr style="font-weight: bold; background: #f0f0f0;">
            <td colspan="3">Totals</td>
            <td>{{ number_format($totalGross, 2) }}</td>
            <td>{{ number_format($totalTaxable, 2) }}</td>
            <td>{{ number_format($totalPaye, 2) }}</td>
        </tr>
    </tbody>
</table>
