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
            <div class="row">
                <div class="col-xxl-12 col-md-12">
                    <div class="card info-card sales-card d-flex flex-row" style="height:60px">
                        <a href="" style="margin-left:15px; margin-top:15px">
                            <i style="font-size:20px;" class="bi bi-search"></i>
                        </a>
                        <input type="date" id="date" onchange="getData()" style="border-color: white;-webkit-box-shadow: none!important;-moz-box-shadow: none!important;box-shadow: none!important;" type="text" class="form-control mt-2" placeholder="Search by date..." value="">
                        <a href="{{ route('admin_add_purchase') }}" type="button" style="padding-top:6px;margin-top:10px;margin-right:15px;height:35px;width: 200px" class="px-4 btn btn-sm btn-dark rounded-pill float-right ml-3">
                            Add New</a>
                    </div>
                </div>
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
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getData(page);
        })
    })

    function getData(page) {
        var date = $('#date').val();
        $.ajax({
            url: `/admin/purchase/data?date=` + date + `&page=` + page,
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

    // function deleteData(id) {
    //     swal({
    //             title: "Are you sure?",
    //             icon: "warning",
    //             buttons: true,
    //             dangerMode: true,
    //         })
    //         .then((willDelete) => {
    //             if (willDelete) {
    //                 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    //                 $.ajax({
    //                     url: `/admin/item/delete/${id}`,
    //                     method: 'DELETE',
    //                     data: {
    //                         _token: CSRF_TOKEN
    //                     },
    //                     beforeSend: function(e) {
    //                         $('#overlay').css("display", "block");
    //                     },
    //                     success: function(res, data) {
    //                         $('#overlay').css("display", "none");
    //                         if (res.status == true) {
    //                             if (res.message != null) {
    //                                 swal("Success", res.message,
    //                                     "warning");
    //                             } else {
    //                                 swal("Success", "Kelas Berhasil Dihapus!",
    //                                     "success");
    //                             }
    //                             getData();
    //                         } else {
    //                             toastr['error']('Something Error');
    //                         }
    //                     },
    //                     error: function(error) {
    //                         $('#overlay').css("display", "none");
    //                         toastr['error']('Something Error');
    //                     }
    //                 })
    //             }
    //         });
    // }
</script>
@endpush