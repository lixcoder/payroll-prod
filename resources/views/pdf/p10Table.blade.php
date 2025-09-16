<table class="table table-bordered mt-3 table-sm no-break">
    <thead class="thead-light">
        <tr>
            <th style="width:40px;">#</th>
            <th>Employee Name</th>
            <th>PIN</th>
            <th class="text-right">Gross Pay (Ksh)</th>
            <th class="text-right">Taxable Pay (Ksh)</th>
            <th class="text-right">PAYE (Ksh)</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
            $totalGross = 0.0;
            $totalTaxable = 0.0;
            $totalPaye = 0.0;
        @endphp

        @foreach($employees as $employee)
            @php
                // Make sure relationships are loaded or exist
                $transactions = $employee->transactions ?? collect();

                // Cast to float in case fields are strings
                $gross = (float) $transactions->sum(function($t){ return (float) ($t->basic_pay ?? 0); });
                $taxable = (float) $transactions->sum(function($t){ return (float) ($t->taxable_income ?? 0); });
                $paye = (float) $transactions->sum(function($t){ return (float) ($t->paye ?? 0); });

                $totalGross += $gross;
                $totalTaxable += $taxable;
                $totalPaye += $paye;
            @endphp

            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $employee->first_name . ' ' . ($employee->middle_name ? $employee->middle_name . ' ' : '') . $employee->last_name }}</td>
                <td>{{ $employee->pin ?? 'N/A' }}</td>
                <td class="text-right">{{ number_format($gross, 2) }}</td>
                <td class="text-right">{{ number_format($taxable, 2) }}</td>
                <td class="text-right">{{ number_format($paye, 2) }}</td>
            </tr>
        @endforeach

        <tr class="font-weight-bold">
            <td colspan="3" class="text-right">Totals</td>
            <td class="text-right">{{ number_format($totalGross, 2) }}</td>
            <td class="text-right">{{ number_format($totalTaxable, 2) }}</td>
            <td class="text-right">{{ number_format($totalPaye, 2) }}</td>
        </tr>
    </tbody>
</table>
