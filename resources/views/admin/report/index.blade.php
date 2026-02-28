@section('title', 'Admin')

@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none">
    <h1 style="margin-left:20px !important;font-size:20px;margin-bottom:14px">Dashboard</h1>
</div>
@endsection

@extends('admin.main')

@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <a href="{{ route('admin_data_monthly_sales_report') }}">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Monthly Sales</h5>
                                <p class="card-text">Report of total monthly sales</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('admin_data_monthly_sales_report') }}">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Item Sales</h5>
                                <p class="card-text">Report of the most selling item</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
<script>

</script>
@endpush