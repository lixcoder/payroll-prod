@extends('layouts.main')
@section('xara_cbs')
    <?php
    use App\Models\Organization;
    use Illuminate\Support\Facades\Auth;
    $organization = Organization::find(Auth::user()->organization_id);
    $installationdate = date('Y-m-d', strtotime($organization->installation_date));
    $splitdate = explode('-', $installationdate);
    $day = $splitdate[2];
    $month = $splitdate[1];
    $year = date('Y');
    $date = date('d-F-Y', strtotime($day . '-' . $month . '-' . $year));
    $todaydate = date('d-F-Y');
    $today = date('Y-m-d');
    ?>

    <style>
        /* Modern Dashboard Styling */
        .dashboard-container {
            background: #f8fafc;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .modern-page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .modern-page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(45deg);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .page-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .breadcrumb-modern {
            background: transparent;
            padding: 0;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .breadcrumb-modern a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb-modern a:hover {
            color: white;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--card-color);
        }

        .stat-card.employees::before { background: linear-gradient(135deg, #10b981, #34d399); }
        .stat-card.leaves::before { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
        .stat-card.payroll::before { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
        .stat-card.users::before { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.employees { background: linear-gradient(135deg, #10b981, #34d399); }
        .stat-icon.leaves { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
        .stat-icon.payroll { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
        .stat-icon.users { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .stat-change {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .stat-change.positive {
            color: #10b981;
        }

        .change-badge {
            background: #dcfce7;
            color: #166534;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .chart-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            background: #fafafa;
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .chart-body {
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 300px;
        }

        .chart-canvas {
            max-width: 100%;
            max-height: 300px;
        }

        /* Alert Styling */
        .modern-alert {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 1px solid #f59e0b;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            color: #92400e;
            font-weight: 500;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-body {
            padding: 3rem;
            text-align: center;
        }

        .modal-icon {
            color: #10b981;
            margin-bottom: 1rem;
        }

        .modal-text {
            font-size: 1.1rem;
            color: #6b7280;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .modern-page-header {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 1rem 0;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-value {
                font-size: 2rem;
            }
        }
    </style>

    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
    
    <div class="dashboard-container">
        <div class="container-fluid px-4">
            <!-- Modern Header -->
            <div class="modern-page-header">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="page-title">Welcome back, {{ optional(Auth::user())->name }}!</h1>
                        <p class="page-subtitle">Here's what's happening with your organization today.</p>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-modern">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/home')}}"><i class="feather icon-home"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item active" style="color: white;">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card employees">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Total Employees</div>
                            <div class="stat-value">{{$employees}}</div>
                            <div class="stat-change positive">
                                <span class="change-badge">+12%</span>
                                <span>from last month</span>
                            </div>
                        </div>
                        <div class="stat-icon employees">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card leaves">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Leave Requests</div>
                            <div class="stat-value">{{$leaves}}</div>
                            <div class="stat-change positive">
                                <span class="change-badge">+12%</span>
                                <span>from last month</span>
                            </div>
                        </div>
                        <div class="stat-icon leaves">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card payroll">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Payroll Processed</div>
                            <div class="stat-value">0</div>
                            <div class="stat-change positive">
                                <span class="change-badge">+12%</span>
                                <span>from last month</span>
                            </div>
                        </div>
                        <div class="stat-icon payroll">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card users">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">System Users</div>
                            <div class="stat-value">{{$users}}</div>
                            <div class="stat-change positive">
                                <span class="change-badge">+12%</span>
                                <span>from last month</span>
                            </div>
                        </div>
                        <div class="stat-icon users">
                            <i class="fas fa-user-cog"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Gender Distribution</h3>
                    </div>
                    <div class="chart-body">
                        <canvas id="genderChart" class="chart-canvas"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Leave Status Overview</h3>
                    </div>
                    <div class="chart-body">
                        <canvas id="leaveChart" class="chart-canvas"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Leave Applications Trend</h3>
                    </div>
                    <div class="chart-body">
                        <canvas id="historyChart" class="chart-canvas"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Payroll Processing History</h3>
                    </div>
                    <div class="chart-body">
                        <canvas id="payrollHistoryChart" class="chart-canvas"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Employee Types Distribution</h3>
                    </div>
                    <div class="chart-body">
                        <canvas id="departmentData" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- License Modal -->
    <div class="modal fade" id="license" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-icon">
                        <i class="fas fa-certificate fa-4x"></i>
                    </div>
                    <p class="modal-text">Your license has expired. Please proceed to license payment to renew your subscription.</p>
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Go to Payment</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Later</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php
    for ($i = 0; $i < 12; $i++) {
        $months[] = date("Y-M", strtotime(date('Y-m-01') . " -$i months"));
    }
    ?>

    <script>
        $(document).ready(function () {
            var due = "<?php echo $organization->license_due_date?>";
            var today = "<?php echo $today?>";
            if (due < today) {
                $("#license").modal("show");
            }
        });

        // Chart.js default configurations
        Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, sans-serif";
        Chart.defaults.color = '#6b7280';
        Chart.defaults.plugins.legend.display = true;
        Chart.defaults.plugins.legend.position = 'bottom';
        Chart.defaults.plugins.legend.labels.padding = 20;
        Chart.defaults.plugins.legend.labels.usePointStyle = true;

        // Gender Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [{{$male}}, {{$female}}],
                    backgroundColor: ['#10b981', '#8b5cf6'],
                    borderWidth: 0,
                    cutout: '65%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { size: 14, weight: '500' }
                        }
                    }
                }
            }
        });

        // Leave Chart
        const leaveCtx = document.getElementById('leaveChart').getContext('2d');
        new Chart(leaveCtx, {
            type: 'doughnut',
            data: {
                labels: ['Approved', 'Cancelled', 'Pending'],
                datasets: [{
                    data: [{{$approved}}, {{$cancelled}}, {{$applied}}],
                    backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                    borderWidth: 0,
                    cutout: '65%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { size: 14, weight: '500' }
                        }
                    }
                }
            }
        });

        // History Chart
        const historyCtx = document.getElementById('historyChart').getContext('2d');
        new Chart(historyCtx, {
            type: 'line',
            data: {
                labels: ['{{$months[11]}}', '{{$months[10]}}', '{{$months[9]}}', '{{$months[8]}}', '{{$months[7]}}', '{{$months[6]}}', '{{$months[5]}}', '{{$months[4]}}', '{{$months[3]}}', '{{$months[2]}}', '{{$months[1]}}', '{{$months[0]}}'],
                datasets: [{
                    label: 'Leave Applications',
                    data: [{{$month12}}, {{$month11}}, {{$month10}}, {{$month9}}, {{$month8}}, {{$month7}}, {{$month6}}, {{$month5}}, {{$month4}}, {{$month3}}, {{$month2}}, {{$month1}}],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { font: { size: 12 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 12 } }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Payroll Chart
        const payrollCtx = document.getElementById('payrollHistoryChart').getContext('2d');
        new Chart(payrollCtx, {
            type: 'line',
            data: {
                labels: ['{{$months[11]}}', '{{$months[10]}}', '{{$months[9]}}', '{{$months[8]}}', '{{$months[7]}}', '{{$months[6]}}', '{{$months[5]}}', '{{$months[4]}}', '{{$months[3]}}', '{{$months[2]}}', '{{$months[1]}}', '{{$months[0]}}'],
                datasets: [{
                    label: 'Amount Processed',
                    data: [{{$monthss12}}, {{$monthss11}}, {{$monthss10}}, {{$monthss9}}, {{$monthss8}}, {{$monthss7}}, {{$monthss6}}, {{$monthss5}}, {{$monthss4}}, {{$monthss3}}, {{$monthss2}}, {{$monthss1}}],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { font: { size: 12 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 12 } }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Department Chart
        const departmentCtx = document.getElementById('departmentData').getContext('2d');
        new Chart(departmentCtx, {
            type: 'bar',
            data: {
                <?php
                $employeeTypes = App\Models\EType::where('organization_id', Auth::user()->organization_id)->get();
                $labels = [];
                $data = [];
                for ($i = 1; $i < count($employeeTypes); $i++) {
                    if (count($employeeTypes[$i]->employees) > 0) {
                        $labels[] = $employeeTypes[$i]->employee_type_name;
                        $data[] = count($employeeTypes[$i]->employees);
                    }
                }
                ?>
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Employee Count',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: ['#10b981', '#8b5cf6', '#f59e0b', '#ef4444', '#3b82f6'],
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { font: { size: 12 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 12 } }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection