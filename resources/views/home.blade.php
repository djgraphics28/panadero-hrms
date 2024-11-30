@extends('layouts.app')

@section('subtitle', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Page Header -->
            <div class="col-md-12 mb-4">
                <h1 class="h3">{{ __('Hello! '. Auth::user()->name ?? 'User') }}</h1>
            </div>
        </div>
        <div class="row">
            <!-- Key Metrics Cards -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>120</h3>
                        <p>Total Employees</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalk"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>8</h3>
                        <p>On Leave</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-time"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>15</h3>
                        <p>Pending Approvals</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-list"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>5</h3>
                        <p>Overdue Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-alert"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <!-- Chart Section -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Monthly Attendance Overview</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <!-- Recent Activities Section -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Recent Activities</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Employee A submitted leave request</li>
                            <li class="list-group-item">Manager B approved a task</li>
                            <li class="list-group-item">New employee added to the system</li>
                            <li class="list-group-item">Payroll for March processed</li>
                            <li class="list-group-item">Holiday schedule updated</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
