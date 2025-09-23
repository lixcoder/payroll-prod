@extends('layouts.hr')
@section('content')
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
                                            <h5 class="mb-0"><i class="feather icon-edit-2 mr-2 text-warning"></i>Update Appraisal Question</h5>
                                            <small class="text-muted">Modify appraisal question information</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('AppraisalSettings') }}" class="btn btn-secondary btn-sm">
                                                <i class="feather icon-arrow-left mr-1"></i> Back to Questions
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong><i class="feather icon-alert-triangle mr-2"></i> Please fix the following errors:</strong>
                                            <ul class="mb-0 mt-2">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Category Creation Modal -->
                                    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="categoryModalLabel">
                                                        <i class="feather icon-plus mr-2"></i>Create New Category
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-info">
                                                        <i class="feather icon-info mr-2"></i>Please enter a new category name.
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="newCategoryName" class="font-weight-bold">Category Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="newCategoryName" placeholder="Enter category name">
                                                        <small class="form-text text-muted">Enter a descriptive name for the category</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary" id="createCategoryBtn">Create Category</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ URL::to('AppraisalSettings/update/'.$appraisal->id) }}" class="modern-form" id="appraisalForm">
                                        @csrf
                                        
                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-info mr-2 text-primary"></i>Question Information
                                            </h6>
                                            <div class="p-3">
                                                <div class="form-group">
                                                    <label for="category" class="font-weight-bold">Category <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light"><i class="feather icon-tag"></i></span>
                                                        </div>
                                                        <select name="category" id="category" class="form-control" required>
                                                            <option value="">Select a category</option>
                                                            <option value="new">+ Create New Category</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $appraisal->appraisalcategory_id == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <small class="form-text text-muted">Select an existing category or create a new one</small>
                                                </div>
                                                
                                                <div class="form-group mt-4">
                                                    <label for="question" class="font-weight-bold">Question <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light"><i class="feather icon-help-circle"></i></span>
                                                        </div>
                                                        <textarea class="form-control" name="question" id="question" rows="3" placeholder="Enter appraisal question" required>{{ $appraisal->question }}</textarea>
                                                    </div>
                                                    <small class="form-text text-muted">Enter the question that will be used for performance appraisal</small>
                                                </div>
                                                
                                                <div class="form-group mt-4">
                                                    <label for="rate" class="font-weight-bold">Rate <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light"><i class="feather icon-star"></i></span>
                                                        </div>
                                                        <input class="form-control" placeholder="Enter rating value" type="number" name="rate" id="rate" value="{{ $appraisal->rate }}" min="1" max="10" step="0.1" required>
                                                    </div>
                                                    <small class="form-text text-muted">Enter the maximum rating value for this question (1-10)</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions text-right p-3 border-top">
                                            <button type="reset" class="btn btn-outline-secondary mr-2">
                                                <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="feather icon-save mr-1"></i> Update Question
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

    <style>
        .modern-form {
            background: #fff;
        }
        
        .card-header {
            background: linear-gradient(135deg, #fef9e7 0%, #f7dc6f 100%);
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
        
        .form-control {
            border: 1px solid #dce4ec;
            border-radius: 6px;
            transition: all 0.3s ease;
            padding: 10px 15px;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        textarea.form-control {
            height: auto;
            min-height: 100px;
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
        
        .btn-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border: none;
            color: white;
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            color: white;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .form-text {
            color: #6c757d;
            font-size: 0.85rem;
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
    <script>
        $(document).ready(function() {
            // Category selection handler
            $('#category').change(function() {
                if ($(this).val() === 'new') {
                    $('#categoryModal').modal('show');
                    $(this).val('{{ $appraisal->appraisalcategory_id }}'); // Reset to current value
                }
            });
            
            // Create category button handler
            $('#createCategoryBtn').click(function() {
                const categoryName = $('#newCategoryName').val().trim();
                
                if (!categoryName) {
                    $('#newCategoryName').addClass('is-invalid');
                    return;
                }
                
                // AJAX request to create new category
                $.ajax({
                    url: "{{ URL::to('createCategory') }}",
                    type: "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'name': categoryName
                    },
                    success: function(response) {
                        // Add new option to select
                        $('#category').append($('<option>', {
                            value: response,
                            text: categoryName,
                            selected: true
                        }));
                        
                        // Close modal and reset
                        $('#categoryModal').modal('hide');
                        $('#newCategoryName').val('').removeClass('is-invalid');
                    },
                    error: function() {
                        alert('Error creating category. Please try again.');
                    }
                });
            });
            
            // Form validation
            $('#appraisalForm').on('submit', function(e) {
                let isValid = true;
                
                // Check required fields
                $('[required]').each(function() {
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
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
            
            // Modal events
            $('#categoryModal').on('hidden.bs.modal', function() {
                $('#newCategoryName').val('').removeClass('is-invalid');
            });
        });
    </script>
@stop