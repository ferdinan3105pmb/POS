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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body mt-4 px-4">
                <form id="formData" method="POST" class="row g-3" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="col-md-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control mb-2" id="name" required autocomplete="off">
                    </div>

                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control mb-2" id="email" required autocomplete="off">
                    </div>

                    <div class="col-md-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control mb-2" id="password" required autocomplete="off">
                    </div>

                    <div class="col-md-12">
                        <label for="class_id" class="form-label">Kelas</label>
                        <select name="class_id" class="form-control" required>
                            <option value="">Pilih Kelas</option> <!-- Default option -->
                            @foreach ($clasess as $key => $class)
                            <option value="{{ $class->id}}">{{$class->name}}</option>
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
</section>
@endsection
@push('css')
@endpush
@push('js')
<script>
    $(document).ready(function() {
        $('#formData').on('submit', function(e) {
            $('.spinner-border').show();
            $(".submit").prop('disabled', true);
            e.preventDefault();
            $('.is-invalid').each(function() {
                $('.is-invalid').removeClass('is-invalid');
            });

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin_post_user') }}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('.spinner-border').hide();
                    if (res.status) {
                        swal("Success", "User Berhasil Di Tambahkan!", "success", {
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
    });
</script>
@endpush