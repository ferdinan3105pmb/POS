@section('title', 'Admin')
@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none" style="margin-left:30px">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin/item') }}">Item</a>
        </li>
        <li class="breadcrumb-item active">Edit Item</li>
    </ol>
</div>
@endsection
@extends('admin.main')
@section('content')
<section class="section dashboard">
    <div class="col-md-12">
        <div class="card mt-4">
            <div class="card-body mt-4 px-4">
                <form id="formData" method="POST" class="row g-3" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" value="{{$item->id}}">
                    <div class="col-md-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control mb-2" id="name" required autocomplete="off" value="{{$item->name}}">
                    </div>

                    <div class="col-md-12">
                        <label for="type_id" class="form-label">Tipe</label>
                        <select name="type_id" class="form-control" required style="margin-bottom: 20px;">
                            <option value="">Pilih Tipe</option> <!-- Default option -->
                            @foreach ($types as $key => $type)
                            <option value="{{ $type->id }}" {{ $type->id == $item->item_type_id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" style="display: flex; justify-content: flex-end;">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border mt-2" role="status" style="display:none;margin-bottom:-90px; margin-right:15px">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn-submit px-4 btn btn-sm btn-dark rounded-pill float-right ml-3">
                                Submit</button>
                        </div>
                        <div class="mx-2">
                            <a href="{{ route('admin_user') }}" class="btn-cancel px-4 btn btn-sm rounded-pill float-right ml-3">
                                Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Modal Variant --}}
    <div class="modal fade" id="addVariantModel" tabindex="-1" aria-labelledby="addVariantLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addVariantLabel">Add New Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body with Form -->
                <form id="formVariant" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$item->id}}">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="color" class="form-label">Warna</label>
                            <input type="text" name="color" class="form-control" id="name">
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" id="price" required>
                        </div>

                        <div class="mb-3">
                            <label for="option" class="form-label">Pilih Size</label>
                            <select name="size" class="form-control" required>
                                <option value="">Pilih Size</option> <!-- Default option -->
                                @foreach ($sizes as $key => $size)
                                <option value="{{ $size->id}}">{{$size->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Stok</label>
                            <input type="number" name="stock" class="form-control" id="stock" required>
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Variant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Question --}}

    <div class="modal fade" id="EditOptionModal" tabindex="-1" aria-labelledby="editOptionLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOptionLabel">Edit Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-option-body">
                    <!-- Options will be loaded here dynamically -->
                    <p class="text-muted">Loading options...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card mt-4">
            <div class="card-body mt-4 px-4">
                <h2>Variasi</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModel">Add Variasi +</button>
                <div class="data" id="data">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@push('js')
<script>
    function getData() {
        let questionId = {{$item->id}};
        $.ajax({
            url: `/admin/item/ajax-data-variant/` + questionId,
            method: 'GET',
            beforeSend: function(e) {
                $('#overlay').css("display", "block");
            },
            success: function(data) {
                $('#overlay').css("display", "none");
                $('#data').html(data);
            },
            error: function(error) {
                $('#overlay').css("display", "none");
                toastr['error']('Something Error');
            }
        })
    }

    $(document).ready(function() {

        getData();

        $('#formData').on('submit', function(e) {
            e.preventDefault();
            $('.spinner-border').show();
            $(".submit").prop('disabled', true);
            e.preventDefault();
            $('.is-invalid').each(function() {
                $('.is-invalid').removeClass('is-invalid');
            });

            var formData = new FormData(this);
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('admin_update_item') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('.spinner-border').hide();
                    if (res.status) {
                        swal("Success", "Item Berhasil Diubah!", "success", {
                            buttons: false,
                            timer: 2000,
                        }).then((value) => {
                            var redirect_url = "{{ route('admin_item') }}"
                            window.location.href = redirect_url;
                        });
                    } else {
                        toastr['error'](res.error);
                    }
                },
                error: function(res) {
                    $('.spinner-border').hide();
                    $(".submit").prop('disabled', false);
                    if (res.status != 422)
                        toastr['error']("Something went wrong");
                    showError(res.responseJSON.errors, "#formData");
                }
            });
            return false;
        })

        $('#formVariant').on('submit', function(e) {
            e.preventDefault();
            $('.spinner-border').show();
            $(".submit").prop('disabled', true);
            e.preventDefault();
            $('.is-invalid').each(function() {
                $('.is-invalid').removeClass('is-invalid');
            });

            var formData = new FormData(this);
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('admin_add_variant') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('.spinner-border').hide();
                    $('#addVariantModel').modal('hide');
                    getData();
                    if (res.status) {
                        swal("Success", "Item Berhasil Diperbaharui!", "success", {
                            buttons: false,
                            timer: 2000,
                        })
                    } else {
                        toastr['error'](res.error);
                    }
                },
                error: function(res) {
                    $('.spinner-border').hide();
                    $(".submit").prop('disabled', false);
                    if (res.status != 422)
                        toastr['error']("Something went wrong");
                    showError(res.responseJSON.errors, "#formVariant");
                }
            });
            return false;
        })

        $(document).on('click', '.edit-option-btn', function() {
            let questionId = $(this).data('id');
            let $modalBody = $('#modal-option-body');
            let modal = $('#EditOptionModal');
            let url = "{{ route('admin_data_variant', ':id') }}".replace(':id', questionId);

            console.log('Clicked ID:', questionId);
            console.log('Modal found:', modal.length > 0);

            $modalBody.html('<p class="text-muted">Loading options...</p>');

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    console.log('AJAX success');
                    $modalBody.html(response);
                    modal.modal('show'); // Bootstrap 5 way
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $modalBody.html('<p class="text-danger">Failed to load options.</p>');
                }
            });

        });


    });
</script>
@endpush