@extends('layouts.main_hr')
@section('xara_cbs')

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0"><i class="feather icon-edit mr-2 text-primary"></i>Update Occurrence</h5>
                                        <small class="text-muted">Edit employee occurrence record</small>
                                    </div>
                                    <div class="card-header-right">
                                        <a href="{{ URL::to('occurences') }}" class="btn btn-secondary btn-sm">
                                            <i class="feather icon-arrow-left mr-1"></i> Back to Occurrences
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Please fix the following errors:</strong>
                                        <ul class="mb-0 mt-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Occurrence Type Creation Modal -->
                                <div id="occurrence-modal" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="feather icon-plus mr-2"></i>Create New Occurrence Type</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <i class="feather icon-info mr-2"></i>Please enter a name for the new occurrence type
                                                </div>
                                                <form id="occurrence-form">
                                                    <div class="form-group">
                                                        <label for="occurrence-name" class="font-weight-bold">Occurrence Type Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="occurrence-name" name="name" required placeholder="Enter occurrence type">
                                                        <div class="invalid-feedback" id="occurrence-name-error"></div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary" id="create-occurrence-type">
                                                    <i class="feather icon-check mr-1"></i> Create
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form method="POST" action="{{ url('occurences/update/'.$occurence->id) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="modern-form">
                                    @csrf
                                    
                                    <input type="hidden" name="employee" id="employee" value="{{ $occurence->employee->id }}">

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-user mr-2 text-primary"></i>Employee Information
                                        </h6>
                                        <div class="p-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Assigned Employee</label>
                                                <div class="employee-display bg-light p-3 rounded">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-primary rounded-circle mr-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="feather icon-user text-white"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $occurence->employee->first_name.' '.$occurence->employee->middle_name.' '.$occurence->employee->last_name }}</h6>
                                                            <small class="text-muted">Employee ID: {{ $occurence->employee->id }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">Employee assignment cannot be changed once created.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-file-text mr-2 text-primary"></i>Occurrence Details
                                        </h6>
                                        <div class="p-3">
                                            <div class="form-group">
                                                <label for="brief" class="font-weight-bold">Occurrence Brief <span class="text-danger">*</span></label>
                                                <input class="form-control" placeholder="Enter occurrence brief" type="text" name="brief" id="brief" value="{{ $occurence->occurence_brief }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="type" class="font-weight-bold">Occurrence Type <span class="text-danger">*</span></label>
                                                <select name="type" id="type" class="form-control select2" required>
                                                    <option value="">Select Occurrence Type</option>
                                                    <option value="cnew">
                                                        <i class="feather icon-plus mr-1"></i> Create New Type
                                                    </option>
                                                    @foreach($occurencesettings as $occurencesetting)
                                                        <option value="{{ $occurencesetting->id }}" {{ $occurence->occurencesetting_id == $occurencesetting->id ? 'selected' : '' }}>
                                                            {{ $occurencesetting->occurence_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="narrative" class="font-weight-bold">Occurrence Narrative</label>
                                                <textarea class="form-control" name="narrative" id="narrative" rows="3" placeholder="Describe the occurrence in detail">{{ $occurence->narrative }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-paperclip mr-2 text-primary"></i>Document Attachment
                                        </h6>
                                        <div class="p-3">
                                            @if($occurence->doc_path)
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Current Document</label>
                                                    <div class="current-document bg-light p-3 rounded">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <i class="feather icon-file-text mr-2 text-primary"></i>
                                                                <span>{{ basename($occurence->doc_path) }}</span>
                                                            </div>
                                                            <a href="{{ asset($occurence->doc_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="feather icon-download mr-1"></i> View
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="path" class="font-weight-bold">Update Document</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="path" id="path">
                                                    <label class="custom-file-label" for="path">Choose new file...</label>
                                                </div>
                                                <small class="form-text text-muted">Leave blank to keep current document</small>
                                            </div>

                                            <div class="form-group">
                                                <label for="date" class="font-weight-bold">Occurrence Date <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input class="form-control datepicker" readonly type="text" name="date" id="date" value="{{ $occurence->occurence_date }}" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions text-right p-3 border-top">
                                        <button type="reset" class="btn btn-outline-secondary mr-2">
                                            <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather icon-save mr-1"></i> Update Occurrence
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<style>
    .modern-form {
        background: #fff;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
    }
    
    .form-section {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background: #fff;
    }
    
    .section-title {
        color: #2c3e50;
        font-weight: 600;
        margin: 0;
        border-radius: 8px 8px 0 0;
    }
    
    .employee-display, .current-document {
        border: 1px solid #e9ecef;
        border-radius: 6px;
    }
    
    .avatar {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    }
    
    .select2-container--default .select2-selection--single {
        height: 44px;
        border: 1px solid #dce4ec;
        border-radius: 6px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 44px;
        padding-left: 15px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px;
    }
    
    .form-control {
        border: 1px solid #dce4ec;
        border-radius: 6px;
        transition: all 0.3s ease;
        height: 44px;
    }
    
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    
    textarea.form-control {
        height: auto;
        resize: vertical;
    }
    
    .custom-file-input:focus ~ .custom-file-label {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    
    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #dce4ec;
        color: #2c3e50;
    }
    
    .btn {
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border: none;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .alert {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .datepicker {
        z-index: 1000 !important;
    }
    
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .card-header-right {
            margin-top: 1rem;
            width: 100%;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
        
        // Initialize datepicker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            endDate: new Date()
        });
        
        // Handle file input change
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
        
        // Handle occurrence type selection
        $('#type').change(function() {
            if ($(this).val() === 'cnew') {
                $('#occurrence-modal').modal('show');
                // Reset the select2 to blank after showing modal
                setTimeout(() => {
                    $(this).val('').trigger('change');
                }, 300);
            }
        });
        
        // Create new occurrence type
        $('#create-occurrence-type').on('click', function() {
            const name = $('#occurrence-name').val().trim();
            const errorDiv = $('#occurrence-name-error');
            
            if (!name) {
                errorDiv.text('Occurrence type name is required');
                $('#occurrence-name').addClass('is-invalid');
                return;
            }
            
            $('#occurrence-name').removeClass('is-invalid');
            
            // AJAX request to create new occurrence type
            $.ajax({
                url: "{{ URL::to('createOccurence') }}",
                type: "POST",
                data: {
                    name: name,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $('#create-occurrence-type').prop('disabled', true).html('<i class="feather icon-loader mr-1"></i> Creating...');
                },
                success: function(response) {
                    // Add new option to select
                    const newOption = new Option(name, response, true, true);
                    $('#type').append(newOption).trigger('change');
                    
                    // Close modal and reset form
                    $('#occurrence-modal').modal('hide');
                    $('#occurrence-name').val('');
                    
                    // Show success message
                    showNotification('Occurrence type created successfully!', 'success');
                },
                error: function(xhr) {
                    errorDiv.text('Error creating occurrence type: ' + (xhr.responseJSON?.message || 'Unknown error'));
                    $('#occurrence-name').addClass('is-invalid');
                },
                complete: function() {
                    $('#create-occurrence-type').prop('disabled', false).html('<i class="feather icon-check mr-1"></i> Create');
                }
            });
        });
        
        // Reset modal when closed
        $('#occurrence-modal').on('hidden.bs.modal', function() {
            $('#occurrence-name').val('').removeClass('is-invalid');
            $('#occurrence-name-error').text('');
        });
        
        // Form validation
        $('form').on('submit', function(e) {
            let isValid = true;
            
            // Basic validation
            $('#brief, #type, #date').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                $('html, body').animate({
                    scrollTop: $('.is-invalid').first().offset().top - 100
                }, 500);
            }
        });
        
        // Remove validation classes on input
        $('input, select, textarea').on('input change', function() {
            $(this).removeClass('is-invalid');
        });
        
        function showNotification(message, type) {
            // Create notification element
            const notification = $('<div class="alert alert-' + type + ' alert-dismissible fade show" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
                '<button type="button" class="close" data-dismiss="alert">×</button>' +
                '<strong>' + message + '</strong>' +
                '</div>');
            
            // Append to body and auto remove after 5 seconds
            $('body').append(notification);
            setTimeout(function() {
                notification.alert('close');
            }, 5000);
        }
    });
</script>
@stop