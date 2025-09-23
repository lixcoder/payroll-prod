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
                                            <h5 class="mb-0"><i class="feather icon-briefcase mr-2 text-primary"></i>Organization Profile</h5>
                                            <small class="text-muted">Manage your company information and branding</small>
                                        </div>
                                        <div class="card-header-right">
                                            <button class="btn btn-outline-primary btn-sm mr-2" data-toggle="modal" data-target="#logo">
                                                <i class="feather icon-image mr-1"></i> Update Logo
                                            </button>
                                            <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#organization">
                                                <i class="feather icon-edit mr-1"></i> Edit Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center mb-4">
                                            <div class="logo-container">
                                                @if ($organization->logo == null)
                                                    <div class="empty-logo">
                                                        <i class="feather icon-camera" style="font-size: 48px; color: #dee2e6;"></i>
                                                        <p class="mt-2 text-muted">No logo uploaded</p>
                                                        <small class="text-muted">Recommended: 300x300px, PNG or JPG</small>
                                                    </div>
                                                @else
                                                    <img src="{{asset('/uploads/logo/'.$organization->logo)}}" alt="Company Logo" class="company-logo img-fluid rounded shadow-sm">
                                                    <div class="mt-2">
                                                        <small class="text-muted">Current logo</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="organization-details">
                                                <div class="detail-card">
                                                    <div class="detail-item">
                                                        <div class="detail-icon">
                                                            <i class="feather icon-briefcase text-primary"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <label class="detail-label">Organization Name</label>
                                                            <p class="detail-value">{{$organization->name}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="detail-item">
                                                        <div class="detail-icon">
                                                            <i class="feather icon-mail text-primary"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <label class="detail-label">Email Address</label>
                                                            <p class="detail-value">{{$organization->email}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="detail-item">
                                                        <div class="detail-icon">
                                                            <i class="feather icon-phone text-primary"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <label class="detail-label">Phone Number</label>
                                                            <p class="detail-value">{{$organization->phone}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="detail-item">
                                                        <div class="detail-icon">
                                                            <i class="feather icon-globe text-primary"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <label class="detail-label">Website</label>
                                                            <p class="detail-value">
                                                                @if($organization->website)
                                                                    <a href="{{$organization->website}}" target="_blank" class="text-primary">{{$organization->website}}</a>
                                                                @else
                                                                    <span class="text-muted">Not provided</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="detail-item">
                                                        <div class="detail-icon">
                                                            <i class="feather icon-map-pin text-primary"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <label class="detail-label">Address</label>
                                                            <p class="detail-value">{{$organization->address ?: 'Not provided'}}</p>
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
        </div>
    </div>

    <!-- Organization Details Modal -->
    <div class="modal fade" id="organization" tabindex="-1" role="dialog" aria-labelledby="organizationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="organizationModalLabel">
                        <i class="feather icon-edit-2 mr-2 text-primary"></i>Update Organization Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ URL::to('organizations/update/'.$organization->id) }}" accept-charset="UTF-8" id="organizationForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">Organization Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="feather icon-briefcase"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Company Name" type="text" name="name" id="name" value="{{ $organization->name }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="font-weight-bold">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="feather icon-phone"></i></span>
                                        </div>
                                        <input class="form-control numbers" maxlength="10" placeholder="Phone Number" type="text" name="phone" id="phone" value="{{ $organization->phone }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="font-weight-bold">Email Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="feather icon-mail"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="email@company.com" type="email" name="email" id="email" value="{{ $organization->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website" class="font-weight-bold">Website</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="feather icon-globe"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="https://company.com" type="text" name="website" id="website" value="{{ $organization->website }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="font-weight-bold">Address</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="feather icon-map-pin"></i></span>
                                </div>
                                <textarea class="form-control" name="address" id="address" rows="3" placeholder="Full physical address">{{ $organization->address }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="feather icon-x mr-1"></i> Cancel
                    </button>
                    <button type="submit" form="organizationForm" class="btn btn-primary">
                        <i class="feather icon-save mr-1"></i> Update Details
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logo Update Modal -->
    <div class="modal fade" id="logo" tabindex="-1" role="dialog" aria-labelledby="logoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoModalLabel">
                        <i class="feather icon-image mr-2 text-primary"></i>Update Organization Logo
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ URL::to('organizations/logo/'.$organization->id) }}" accept-charset="UTF-8" enctype="multipart/form-data" id="logoForm">
                        @csrf

                        <div class="form-group">
                            <label for="photo" class="font-weight-bold">Upload Logo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="photo" id="photo" accept="image/*" required>
                                <label class="custom-file-label" for="photo">Choose logo file...</label>
                            </div>
                            <small class="form-text text-muted">Recommended: 300x300px, PNG or JPG format. Max 2MB.</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="feather icon-info mr-2"></i>
                            Uploading a new logo will replace the existing one.
                        </div>

                        @if (Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="feather icon-alert-triangle mr-2"></i>
                                @if (is_array(Session::get('error')))
                                    {{ head(Session::get('error')) }}
                                @else
                                    {{ Session::get('error') }}
                                @endif
                            </div>
                        @endif

                        @if (Session::get('notice'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="feather icon-check-circle mr-2"></i>{{ Session::get('notice') }}
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="feather icon-x mr-1"></i> Cancel
                    </button>
                    <button type="submit" form="logoForm" class="btn btn-primary">
                        <i class="feather icon-upload mr-1"></i> Upload Logo
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .logo-container {
            padding: 20px;
            border: 2px dashed #dee2e6;
            border-radius: 12px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .logo-container:hover {
            border-color: #3498db;
            background: #f1f8ff;
        }
        
        .empty-logo {
            padding: 40px 20px;
            color: #6c757d;
        }
        
        .company-logo {
            max-width: 200px;
            max-height: 200px;
            border: 3px solid #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .detail-card {
            background: #fff;
            border-radius: 12px;
            padding: 0;
        }
        
        .detail-item {
            display: flex;
            align-items: flex-start;
            padding: 20px;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .detail-icon i {
            color: white;
            font-size: 18px;
        }
        
        .detail-content {
            flex: 1;
        }
        
        .detail-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
        
        .detail-value {
            color: #495057;
            margin-bottom: 0;
            font-size: 1.1rem;
            word-break: break-word;
        }
        
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .form-control {
            border: 1px solid #dce4ec;
            border-radius: 6px;
            transition: all 0.3s ease;
            height: 44px;
            padding: 10px 15px;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #dce4ec;
            color: #2c3e50;
        }
        
        .custom-file-input:focus ~ .custom-file-label {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        @media (max-width: 768px) {
            .detail-item {
                flex-direction: column;
                text-align: center;
            }
            
            .detail-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
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

    <script>
        $(document).ready(function() {
            // Custom file input
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
            
            // Form validation
            $('#organizationForm').on('submit', function(e) {
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
            $('input, textarea').on('input', function() {
                $(this).removeClass('is-invalid');
            });
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop