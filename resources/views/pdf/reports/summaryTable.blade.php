
<?php

function asMoney($value)
{
    return number_format($value, 2);
}
?>
<table>
    <?php if ($selBranch == 'All' && $selDept == 'All'){ ?>
    <tr>
        <td><strong>Branch:</strong></td>
        <td>All</td>
    </tr>
    <tr>
        <td><strong>Department:</strong></td>
        <td>All</td>
    </tr>
    <?php }else if ($selBranch == 'All'){ ?>
    <tr>
        <td><strong>Branch:</strong></td>
        <td>All</td>
    </tr>
    <tr>
        <td><strong>Department:</strong></td>
        <td>{{$sels->name}}</td>
    </tr>
    <?php }else if ($selDept == 'All'){ ?>
    <tr>
        <td><strong>Branch:</strong></td>
        <td>{{$sels->name}}</td>
    </tr>
    <tr>
        <td><strong>Department:</strong></td>
        <td>All</td>
    </tr>
    <?php }else if ($selDept != 'Áll' && $selBranch != 'All'){ ?>
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
        <td>
            <strong>Currency:</strong></td>
        {{--        @foreach($currencies as $currency)--}}
        <td>{{$currency->shortname}}</td>
        {{--        @endforeach--}}
    </tr>
    <tr>
        <td><strong>Period:</strong></td>
        <td>{{$period}}</td>
    </tr>
</table>
<table>
    <tr>
        <td><strong># </strong></td>
        <td><strong>Payroll Number </strong></td>
        <td><strong>Employee Name </strong></td>
        <td><strong>Basic Pay </strong></td>
        <td><strong>Allowance </strong></td>
        <td><strong>Gross Pay </strong></td>
        <td><strong>Paye</strong></td>
        <td><strong>Nssf Amount</strong></td>
        <td><strong>Nhif Amount</strong></td>
        <td><strong>Other Deductions</strong></td>
        <td><strong>Total Deductions </strong></td>
        <td><strong>Net Pay </strong></td>
    </tr>
    <?php $i = 1; ?>
    @foreach($data as $sum)
        <tr>


            <td td width='20'>{{$i}}</td>
            <td> {{ $sum->personal_file_number }}</td>
            @if($sum->middle_name != null || $sum->middle_name != '')
                <td> {{$sum->first_name.' '.$sum->middle_name.' '.$sum->last_name}}</td>
            @else
                <td> {{$sum->first_name.' '.$sum->last_name}}</td>
            @endif
            <td align="right"> {{ asMoney($sum->basic_pay) }}</td>
            <td align="right"> {{ asMoney($sum->earning_amount) }}</td>
            <td align="right"> {{ asMoney($sum->taxable_income) }}</td>
            <td align="right"> {{ asMoney($sum->paye) }}</td>
            <td align="right"> {{ asMoney($sum->nssf_amount) }}</td>
            <td align="right"> {{ asMoney($sum->nhif_amount) }}</td>
            <td align="right"> {{ asMoney($sum->other_deductions) }}</td>
            <td align="right"> {{ asMoney($sum->total_deductions) }}</td>
            <td align="right"> {{ asMoney($sum->net ) }}</td>
        </tr>
            <?php $i++; ?>

    @endforeach

    <tr>
        <td colspan='3' align="right"><strong>Total: </strong></td>

        <td align="right" width="20">{{ asMoney($total_pay ) }}</td>
        <td align="right" width="20">{{ asMoney($total_earning ) }}</td>
        <td align="right" width="20">{{ asMoney($total_gross ) }}</td>
        <td align="right" width="20">{{ asMoney($total_paye ) }}</td>
        <td align="right" width="20">{{ asMoney($total_nssf ) }}</td>
        <td align="right" width="20">{{ asMoney($total_nhif ) }}</td>
        <td align="right" width="20">{{ asMoney($total_others ) }}</td>
        <td align="right" width="20">{{ asMoney($total_deds ) }}</td>
        <td align="right" width="20">{{ asMoney($total_net ) }}</td>
    </tr>


    <tr>
        <td align="right" colspan='11'><strong>Total net:</strong></td>
        <td align="right" width="30">{{ asMoney($total_net ) }}</td>
    </tr>

</table>
<table>
    <tr>
        <td><strong>Prepared By:</strong></td>
        <td>
        </td>
    </tr>
    <tr>
        <td></td>
        <td align="center" width="30"><strong>Name</strong></td>
        <td align="center" width="30"><strong>Signature</strong></td>
        <td align="center" width="30"><strong>Date</strong></td>
    </tr>
    <tr>
        <td ></td>
    </tr>
    <tr>
        <td ><strong>Approved By:</strong></td>
        <td >

        </td>
        <td >

        </td>
        <td >
            <hr>
        </td>
    </tr>
    <tr>
        <td></td>
        <td align="center" width="30"><strong>Name</strong></td>
        <td align="center" width="30"><strong>Signature</strong></td>
        <td align="center" width="30"><strong>Date</strong></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td ><strong>Authorized By:</strong></td>
        <td >

        </td>
        <td >

        </td>
        <td>

        </td>
    </tr>
    <tr>
        <td></td>
        <td align="center"><strong>Name</strong></td>
        <td align="center"><strong>Signature</strong></td>
        <td align="center"><strong>Date</strong></td>
    </tr>
</table>
