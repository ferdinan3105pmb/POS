@section('title', 'Admin')
@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none" style="margin-left:30px">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin/user') }}">User</a>
        </li>
        <li class="breadcrumb-item active">Edit User</li>
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
                    <input type="hidden" name="id" value="{{$staff->id}}">

                    <div class="col-md-12">
                        <label for="name" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control mb-2" id="email" required autocomplete="off" value="{{$staff->email}}">
                    </div>

                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeUserPasswordModal">Ubah Password User</button>
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

    <div class="modal fade" id="changeUserPasswordModal" tabindex="-1" aria-labelledby="changeUserPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionLabel">Ubah Password User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body with Form -->
                <form id="formPassword" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$staff->id}}">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control mb-2" id="password" required autocomplete="off">
                        </div>

                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
@endsection
@push('css')
@endpush
@push('js')
<script>
    $(document).ready(function() {
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
                url: "{{ route('admin_update_user') }}",
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
                        swal("Success", "User Berhasil Diubah!", "success", {
                            buttons: false,
                            timer: 2000,
                        }).then((value) => {
                            var redirect_url = "{{ route('admin_user') }}"
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


        $('#formPassword').on('submit', function(e) {
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
                url: "{{ route('admin_password_user') }}",
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
                    $('#changeUserPasswordModal').modal('hide');

                    if (res.status) {
                        swal("Success", "Password User Berhasil Diubah!", "success", {
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
                    showError(res.responseJSON.errors, "#formPassword");
                }
            });
            return false;
        })
    });
</script>
@endpush