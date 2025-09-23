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
                                        <h5 class="mb-0"><i class="feather icon-award mr-2 text-primary"></i>New Appraisal</h5>
                                        <small class="text-muted">Create employee performance evaluation</small>
                                    </div>
                                    <div class="card-header-right">
                                        <a href="{{ URL::to('Appraisals') }}" class="btn btn-secondary btn-sm">
                                            <i class="feather icon-arrow-left mr-1"></i> Back to Appraisals
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

                                <!-- Appraisal Question Creation Modal -->
                                <div id="question-modal" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="feather icon-plus mr-2"></i>Create New Appraisal Question</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <i class="feather icon-info mr-2"></i>Please fill all required fields
                                                </div>
                                                <form id="question-form">
                                                    <div class="form-group">
                                                        <label for="category" class="font-weight-bold">Category <span class="text-danger">*</span></label>
                                                        <select name="category" id="category" class="form-control" required>
                                                            <option value="">Select Category</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback" id="category-error"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="question" class="font-weight-bold">Question <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="question" id="question" rows="3" placeholder="Enter appraisal question" required></textarea>
                                                        <div class="invalid-feedback" id="question-error"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="rate" class="font-weight-bold">Maximum Score <span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" name="rate" id="rate" placeholder="Enter maximum score" min="1" required>
                                                        <div class="invalid-feedback" id="rate-error"></div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary" id="create-question">
                                                    <i class="feather icon-check mr-1"></i> Create Question
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form method="POST" action="{{ url('Appraisals') }}" class="modern-form">
                                    @csrf
                                    
                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-user mr-2 text-primary"></i>Employee Information
                                        </h6>
                                        <div class="p-3">
                                            <div class="form-group">
                                                <label for="employee_id" class="font-weight-bold">Employee <span class="text-danger">*</span></label>
                                                <select name="employee_id" id="employee_id" class="form-control select2" required>
                                                    <option value="">Select Employee</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                            {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-file-text mr-2 text-primary"></i>Appraisal Details
                                        </h6>
                                        <div class="p-3">
                                            <div class="form-group">
                                                <label for="appraisal_id" class="font-weight-bold">Appraisal Question <span class="text-danger">*</span></label>
                                                <select name="appraisal_id" id="appraisal_id" class="form-control select2" required>
                                                    <option value="">Select Appraisal Question</option>
                                                    <option value="cnew" {{ old('appraisal_id') == 'cnew' ? 'selected' : '' }}>
                                                        <i class="feather icon-plus mr-1"></i> Create New Question
                                                    </option>
                                                    @foreach($appraisals as $appraisal)
                                                        <option value="{{ $appraisal->id }}" data-maxscore="{{ $appraisal->rate }}" {{ old('appraisal_id') == $appraisal->id ? 'selected' : '' }}>
                                                            {{ $appraisal->question }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="performance" class="font-weight-bold">Performance Rating <span class="text-danger">*</span></label>
                                                <select name="performance" id="performance" class="form-control" required>
                                                    <option value="">Select Performance Rating</option>
                                                    <option value="Outstanding" {{ old('performance') == 'Outstanding' ? 'selected' : '' }}>Outstanding</option>
                                                    <option value="Exceeds Expectations" {{ old('performance') == 'Exceeds Expectations' ? 'selected' : '' }}>Exceeds Expectations</option>
                                                    <option value="Meets Expectations" {{ old('performance') == 'Meets Expectations' ? 'selected' : '' }}>Meets Expectations</option>
                                                    <option value="Needs Improvements" {{ old('performance') == 'Needs Improvements' ? 'selected' : '' }}>Needs Improvements</option>
                                                    <option value="Unsatisfactory" {{ old('performance') == 'Unsatisfactory' ? 'selected' : '' }}>Unsatisfactory</option>
                                                    <option value="Not Applicable" {{ old('performance') == 'Not Applicable' ? 'selected' : '' }}>Not Applicable</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold">Score <span class="text-danger">*</span></label>
                                                <div class="row align-items-center">
                                                    <div class="col-md-4">
                                                        <input class="form-control" placeholder="Score" type="number" name="score" id="score" value="{{ old('score') }}" min="0" required>
                                                    </div>
                                                    <div class="col-md-1 text-center">
                                                        <span class="text-muted">out of</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control bg-light" readonly type="number" name="maxscore" id="maxscore" value="{{ old('maxscore') }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span id="score-percentage" class="badge badge-info"></span>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted" id="score-help">Enter score between 0 and maximum value</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-calendar mr-2 text-primary"></i>Evaluation Details
                                        </h6>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="examiner" class="font-weight-bold">Examiner</label>
                                                        <input class="form-control" readonly type="text" name="examiner" id="examiner" value="{{ Auth::user()->username }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date" class="font-weight-bold">Date <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input class="form-control datepicker" readonly type="text" name="date" id="date" value="{{ date('Y-m-d') }}" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="comment" class="font-weight-bold">Comments</label>
                                                <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Enter evaluation comments">{{ old('comment') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions text-right p-3 border-top">
                                        <button type="reset" class="btn btn-outline-secondary mr-2">
                                            <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather icon-save mr-1"></i> Create Appraisal
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
    
    #score-percentage {
        font-size: 0.9rem;
        padding: 0.5rem 0.8rem;
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
            width: '100%',
            dropdownParent: $('#employee_id').closest('.form-group')
        });
        
        // Initialize datepicker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            endDate: new Date()
        });
        
        // Handle appraisal question selection
        $('#appraisal_id').change(function() {
            if ($(this).val() === 'cnew') {
                $('#question-modal').modal('show');
                // Reset the select2 to blank after showing modal
                setTimeout(() => {
                    $(this).val('').trigger('change');
                }, 300);
            } else {
                const selectedOption = $(this).find('option:selected');
                const maxScore = selectedOption.data('maxscore') || 0;
                $('#maxscore').val(maxScore);
                updateScorePercentage();
            }
        });
        
        // Handle score input
        $('#score').on('input', function() {
            validateScore();
            updateScorePercentage();
        });
        
        // Create new question
        $('#create-question').on('click', function() {
            const category = $('#category').val();
            const question = $('#question').val().trim();
            const rate = $('#rate').val();
            
            // Reset errors
            $('.invalid-feedback').text('');
            $('#category, #question, #rate').removeClass('is-invalid');
            
            let isValid = true;
            
            if (!category) {
                $('#category-error').text('Please select a category');
                $('#category').addClass('is-invalid');
                isValid = false;
            }
            
            if (!question) {
                $('#question-error').text('Please enter a question');
                $('#question').addClass('is-invalid');
                isValid = false;
            }
            
            if (!rate || rate <= 0) {
                $('#rate-error').text('Please enter a valid maximum score');
                $('#rate').addClass('is-invalid');
                isValid = false;
            }
            
            if (isValid) {
                // AJAX request to create new question
                $.ajax({
                    url: "{{ url('createQuestion') }}",
                    type: "POST",
                    data: {
                        category: category,
                        question: question,
                        rate: rate,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#create-question').prop('disabled', true).html('<i class="feather icon-loader mr-1"></i> Creating...');
                    },
                    success: function(response) {
                        // Add new option to select
                        const newOption = new Option(question, response, true, true);
                        $('#appraisal_id').append(newOption).trigger('change');
                        
                        // Set maxscore
                        $('#maxscore').val(rate);
                        
                        // Close modal and reset form
                        $('#question-modal').modal('hide');
                        $('#category, #question, #rate').val('');
                    },
                    error: function(xhr) {
                        alert('Error creating question: ' + (xhr.responseJSON?.message || 'Unknown error'));
                    },
                    complete: function() {
                        $('#create-question').prop('disabled', false).html('<i class="feather icon-check mr-1"></i> Create Question');
                    }
                });
            }
        });
        
        // Reset modal when closed
        $('#question-modal').on('hidden.bs.modal', function() {
            $('#category, #question, #rate').val('').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        });
        
        function validateScore() {
            const score = parseInt($('#score').val()) || 0;
            const maxScore = parseInt($('#maxscore').val()) || 0;
            
            if (maxScore > 0 && score > maxScore) {
                $('#score-help').html('<span class="text-danger">Score cannot exceed maximum value of ' + maxScore + '</span>');
                $('#score').addClass('is-invalid');
                return false;
            } else {
                $('#score-help').text('Enter score between 0 and ' + maxScore);
                $('#score').removeClass('is-invalid');
                return true;
            }
        }
        
        function updateScorePercentage() {
            const score = parseInt($('#score').val()) || 0;
            const maxScore = parseInt($('#maxscore').val()) || 1;
            
            if (maxScore > 0) {
                const percentage = Math.round((score / maxScore) * 100);
                $('#score-percentage').text(percentage + '%');
                
                // Update badge color based on percentage
                if (percentage >= 90) {
                    $('#score-percentage').removeClass('badge-info badge-warning badge-danger').addClass('badge-success');
                } else if (percentage >= 70) {
                    $('#score-percentage').removeClass('badge-success badge-warning badge-danger').addClass('badge-info');
                } else if (percentage >= 50) {
                    $('#score-percentage').removeClass('badge-success badge-info badge-danger').addClass('badge-warning');
                } else {
                    $('#score-percentage').removeClass('badge-success badge-info badge-warning').addClass('badge-danger');
                }
            }
        }
        
        // Form validation
        $('form').on('submit', function(e) {
            let isValid = true;
            
            // Basic validation
            $('#employee_id, #appraisal_id, #performance, #score, #date').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            // Score validation
            if (!validateScore()) {
                isValid = false;
            }
            
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
        
        // Initialize maxscore if an appraisal is pre-selected
        const selectedAppraisal = $('#appraisal_id option:selected');
        if (selectedAppraisal.length && selectedAppraisal.val() !== 'cnew') {
            const maxScore = selectedAppraisal.data('maxscore') || 0;
            $('#maxscore').val(maxScore);
            updateScorePercentage();
        }
    });
</script>
@stop