@extends('layouts.main_hr')

<?php function asMoney($value)
{
    return number_format($value, 2);
}
?>

@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Payroll Calculator</h3>
                            <hr/>
                        </div>
                        <div class="col-lg-12">
                            <div class="card card-tabs">
                                <div class="card-header p-0 pt-0">
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div>
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item">
                                                <a href="#grosstonet" class="nav-link active" aria-controls="grosstonet"
                                                   role="tab"
                                                   data-toggle="tab" aria-selected="true">
                                                    Gross to Net
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#nettogross" aria-controls="nettogross" role="tab"
                                                   class="nav-link"
                                                   data-toggle="tab">
                                                    Net to Gross
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active displayrecord"
                                                     id="grosstonet">
                                                    <form id="grossform" accept-charset="UTF-8">
                                                        <fieldset>
                                                            <?php
                                                            $a = str_replace(',', '', request()->input('gross'));
                                                            ?>

                                                            <div class="form-group">
                                                                <label for="gross">Gross Pay:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input class="form-control" placeholder="Enter gross salary" 
                                                                           type="text" name="gross" id="gross" 
                                                                           value="{{!empty($a) ? asMoney($a) : '0.00'}}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="paye">PAYE Tax:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control bg-light" placeholder="" 
                                                                           type="text" name="paye" id="paye" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="nssf">NSSF:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control bg-light" placeholder=""
                                                                           type="text" name="nssf" id="nssf" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="shif">SHIF:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control bg-light" placeholder="" 
                                                                           type="text" name="shif" id="shif" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="housing_levy">Housing Levy:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control bg-light" placeholder="" 
                                                                           type="text" name="housing_levy" id="housing_levy" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="net">Net Pay:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control font-weight-bold" 
                                                                           placeholder="" type="text" name="net" id="net" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div align="right" class="form-actions form-group">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-calculator"></i> Calculate Net Pay
                                                                </button>
                                                            </div>
                                                        </fieldset>
                                                    </form>
                                                </div>

                                                {{-- NET TO GROSS --}}
                                                <div role="tabpanel" class="tab-pane" id="nettogross">
                                                    <form id="netform" accept-charset="UTF-8">
                                                        <fieldset>
                                                            <?php
                                                            $b = str_replace(',', '', request()->input('net1'));
                                                            ?>

                                                            <div class="form-group">
                                                                <label for="net1">Net Pay:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input class="form-control" placeholder="Enter desired net salary" 
                                                                           type="text" name="net1" id="net1" 
                                                                           value="{{!empty($b) ? asMoney($b) : '0.00'}}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="gross1">Gross Pay:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input class="form-control font-weight-bold" 
                                                                           readonly placeholder="" type="text" name="gross1" id="gross1" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="paye1">PAYE Tax:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control bg-light" placeholder="" 
                                                                           type="text" name="paye1" id="paye1" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="nssf1">NSSF:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control bg-light" placeholder=""
                                                                           type="text" name="nssf1" id="nssf1" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="shif1">SHIF:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control bg-light" placeholder="" 
                                                                           type="text" name="shif1" id="shif1" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="housing_levy1">Housing Levy:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" style="margin: 0px">{{$currency->shortname}}</span>
                                                                    </div>
                                                                    <input readonly class="form-control bg-light" placeholder="" 
                                                                           type="text" name="housing_levy1" id="housing_levy1" value="0.00">
                                                                </div>
                                                            </div>

                                                            <div align="right" class="form-actions form-group">
                                                                <button type="submit" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-calculator"></i> Calculate Gross Pay
                                                                </button>
                                                            </div>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
    // Format number input as user types
    function formatNumberInput(input) {
        let value = input.val().replace(/[,\s]/g, '').trim();
        
        // Check if it's a valid number (allows integers and decimals)
        if (/^\d+(\.\d{0,2})?$/.test(value) && parseFloat(value) > 0) {
            input.val(parseFloat(value).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        } else if (value === '' || value === '0') {
            input.val('0.00');
        } else {
            // If not a valid number, revert to previous formatted value or 0.00
            let previousValue = input.data('previous-value') || '0.00';
            input.val(previousValue);
        }
        
        // Store the current formatted value for potential reversion
        input.data('previous-value', input.val());
    }

    // Validate input before processing
    function validateNumberInput(inputValue, fieldName) {
        let cleanValue = inputValue.replace(/[,\s]/g, '').trim();
        
        if (!/^\d+(\.\d{0,2})?$/.test(cleanValue) || parseFloat(cleanValue) <= 0) {
            return { valid: false, message: `Please enter a valid ${fieldName}` };
        }
        
        return { valid: true, value: parseFloat(cleanValue) };
    }

    // Format gross input on blur
    $('#gross').on('blur', function() {
        formatNumberInput($(this));
    });

    // Format net input on blur
    $('#net1').on('blur', function() {
        formatNumberInput($(this));
    });

    // Store initial values
    $('#gross').data('previous-value', $('#gross').val());
    $('#net1').data('previous-value', $('#net1').val());

    // Gross to Net calculation
    $('#grossform').on('submit', function (event) {
        event.preventDefault();
        
        let grossValue = $('#gross').val();
        let validation = validateNumberInput(grossValue, 'gross salary');
        
        if (!validation.valid) {
            alert(validation.message);
            return;
        }

        // Show loading state
        let submitBtn = $(this).find('button[type="submit"]');
        let originalText = submitBtn.html();
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Calculating...').prop('disabled', true);

        $.ajax({
            url: "{{route('payroll.shownet')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                'formdata': $(this).serialize(),
                '_token': '{{ csrf_token() }}'
            },
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    return;
                }
                
                // Update all fields
                $('#gross').val(data.gross);
                $('#paye').val(data.paye);
                $('#nssf').val(data.nssf);
                $('#shif').val(data.shif);
                $('#housing_levy').val(data.housing_levy || '0.00');
                $('#net').val(data.net);
                
                // Update stored values
                $('#gross').data('previous-value', data.gross);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    alert('Error: ' + xhr.responseJSON.error);
                } else {
                    alert('An error occurred while calculating. Please try again.');
                }
            },
            complete: function() {
                // Reset button state
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Net to Gross calculation
    $('#netform').on('submit', function (event) {
        event.preventDefault();
        
        let netValue = $('#net1').val();
        let validation = validateNumberInput(netValue, 'net salary');
        
        if (!validation.valid) {
            alert(validation.message);
            return;
        }

        // Show loading state
        let submitBtn = $(this).find('button[type="submit"]');
        let originalText = submitBtn.html();
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Calculating...').prop('disabled', true);

        $.ajax({
            url: "{{route('payroll.showgross')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                'formdata': $(this).serialize(),
                '_token': '{{ csrf_token() }}'
            },
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    return;
                }
                                
                // Update all fields
                $('#gross1').val(data.gross1);
                $('#paye1').val(data.paye1);
                $('#nssf1').val(data.nssf1);
                $('#shif1').val(data.shif);
                $('#housing_levy1').val(data.housing_levy1 || '0.00');
                $('#net1').val(data.netv);
                
                // Update stored values
                $('#net1').data('previous-value', data.netv);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    alert('Error: ' + xhr.responseJSON.error);
                } else {
                    alert('An error occurred while calculating. Please try again.');
                }
            },
            complete: function() {
                // Reset button state
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});
    </script>
@endsection