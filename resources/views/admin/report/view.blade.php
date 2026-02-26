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
        <div class="col-md-12">
            <div class="card info-card sales-card d-flex flex-row" style="height:60px">
                <select id="sort" onchange="getData()" class="form-select mt-2" style="width: 200px;">
                    <option value="">Sort by</option>
                    <option value="name">Name</option>
                    <option value="grade">Grade</option>
                </select>
                <select id="type" onchange="getData()" class="form-select mt-2" style="width: 200px;">
                    <option value="">Sort Type</option>
                    <option value="ASC">ASC</option>
                    <option value="DESC">DESC</option>
                </select>
            </div>

            <div class="data" id="data">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        getData();
    })

    function getData() {
        var sortBy = $('#sort').val();
        var type = $('#type').val();
        var id = "{{ $id }}";
        $.ajax({
            url: `/admin/report/view/detail/${id}?sort=${sortBy}&type=${type}`,
            method: 'GET',
            beforeSend: function(e) {
                $('#overlay').css("display", "block");
            },
            success: function(data) {
                $('#overlay').css("display", "none");
                console.log(data);
                $('#data').html(data);
            },
            error: function(error) {
                $('#overlay').css("display", "none");
                toastr['error']('Something Error');
            }
        })
    }
</script>
@endpush