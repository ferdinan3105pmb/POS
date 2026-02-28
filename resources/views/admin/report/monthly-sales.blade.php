@section('title', 'Admin')
@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none" style="margin-left:30px">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin/user') }}">User</a>
        </li>
        <li class="breadcrumb-item active">Add New</li>
    </ol>
</div>
@endsection
@extends('admin.main')
@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="container">
            <div class="row g-4">

                <div class="col-md-12" id="sales-summary">

                </div>
                
                <input id="month" onchange="getDoughnutChart()" style="border-color: white;-webkit-box-shadow: none!important;-moz-box-shadow: none!important;box-shadow: none!important;" type="month" class="form-control mt-2" value="">
                <div class="col-md-4 card h-100 shadow-sm" id="doughnut-chart">
                </div>

                <div class="col-md-8">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <table id="data" class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Total Qty</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@push('css')
@endpush
@push('js')
<script>
    function getDoughnutChart() {
        var month = $('#month').val();
        $.ajax({
            url: `/admin/report/doughnut-chart?month=` + month,
            method: 'GET',
            beforeSend: function(e) {
                $('#overlay').css("display", "block");
            },
            success: function(data) {
                $('#overlay').css("display", "none");
                $('#doughnut-chart').html(data);
                salesSummary();
                loadTable();
            },
            error: function(error) {
                if (fromAbort) {
                    fromAbort = false;
                    return;
                }
                $('#overlay').css("display", "none");
                toastr['error']('Something Error');
            }
        })
    }

    function salesSummary() {
        var month = $('#month').val();
        $.ajax({
            url: `/admin/report/sales-summary?month=` + month,
            method: 'GET',
            beforeSend: function(e) {
                $('#overlay').css("display", "block");
            },
            success: function(data) {
                $('#overlay').css("display", "none");
                console.log(data);
                $('#sales-summary').html(data);
            },
            error: function(error) {
                $('#overlay').css("display", "none");
                toastr['error']('Something Error');
            }
        })
    }

    function loadTable(month) {
        $('#data').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: `/admin/report/item-sales-report?`,
                data: function(d) {
                    d.month = month;
                }
            },
            columns: [{
                    data: 'item_name'
                },
                {
                    data: 'size',
                    render: function(data) {
                        const sizes = {
                            1: 'S',
                            2: 'M',
                            3: 'L',
                            4: 'XL',
                            5: 'XXL',
                            6: 'XXXL',
                            7: 'XXXXL',
                        };

                        return sizes[data] ?? '-';
                    }
                },
                {
                    data: 'color'
                },
                {
                    data: 'total_qty'
                },
                {
                    data: 'total_sales',
                    render: function(data) {
                        return 'Rp ' + parseInt(data).toLocaleString();
                    }
                }
            ]
        });
    }
    getDoughnutChart();
</script>
@endpush