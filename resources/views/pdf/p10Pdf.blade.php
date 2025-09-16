<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>P10 Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* small tweaks for PDF rendering */
        body { font-size: 12px; }
        .no-break { page-break-inside: avoid; }
    </style>
</head>
<body>
    <center class="mb-3">
        <img src="https://www.kra.go.ke/templates/kra/images/kra/logo.png" alt="logo" class="img-fluid" style="max-height:70px;">
        <p class="mb-0">Kenya Revenue Authority</p>
        <p class="mb-0">Domestic Taxes Department</p>
        <p class="mb-0"><strong>Employer’s PAYE Return (P10) for Year <b>{{ $year }}</b></strong></p>
    </center>

    <div class="container mt-3">
        <div class="row mb-2">
            <div class="col-8">
                <h6 class="mb-0"><strong>Employer Name:</strong> {{ $organization->name }}</h6>
            </div>
            <div class="col-4 text-right">
                <h6 class="mb-0"><strong>Employer PIN:</strong> {{ $organization->tax_number_1 }}</h6>
            </div>
        </div>

        {{-- include the table partial (only the table markup) --}}
        @include('pdf.p10Table')
    </div>
</body>
</html>
