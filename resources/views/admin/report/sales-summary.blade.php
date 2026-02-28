<div class="row">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <a href="{{ route('admin_data_monthly_sales_report') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Monthly Sales</h5>
                            <h3 class="card-text">{{format_idr($total_sales)}}</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{ route('admin_data_monthly_sales_report') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Item Sales</h5>
                            <h3 class="card-text">{{$total_detail}}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>