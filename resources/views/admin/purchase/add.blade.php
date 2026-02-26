@section('title', 'Admin')
@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none" style="margin-left:30px">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin/purchase') }}">Purchase</a>
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
                <div class="col-md-12">
                    <label for="class_id" class="form-label">Tipe</label>
                    <select name="type_id" id="type_id" class="form-control" required>
                        <option value="">Pilih Tipe</option> <!-- Default option -->
                        @foreach ($types as $key => $type)
                        <option value="{{ $type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-12 my-2">
                    <label for="item" class="form-label">Item</label>
                    <select name="item" id="item" class="form-control" required>
                    </select>
                </div>

                <div class="col-md-12 my-2">
                    <label for="variant" class="form-label">Item Variant</label>
                    <select name="variant" id="variant" class="form-control" required>
                    </select>
                </div>

                <div class="col-md-12 my-2">
                    <p name="price" id="price"></p>
                </div>

                <div class="col-md-12 my-2">
                    <label for="qty" class="form-label">Qty</label>
                    <input type="number" name="qty" id="qty" class="form-control">
                </div>

                <div class="my-3" style="display: flex; justify-content: flex-end;">
                    <div>
                        <button type="button" id="btnAdd"
                            class="px-4 btn btn-sm btn-success rounded-pill">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card my-2">
            <div class="card-body mt-4 px-4">
                <h2>Daftar Pembelian</h2>
                <form id="formData" method="POST" class="row g-3" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <table class="table table-borderless table-hover my-2">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Variant</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="purchaseTable"></tbody>
                    </table>

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
    function removeRow(id) {
        $('#row' + id).remove();
    }

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
                url: "{{ route('admin_post_purchase') }}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('.spinner-border').hide();
                    if (res.status) {
                        swal("Success", "Purchase Berhasil Di Tambahkan!", "success", {
                            buttons: false,
                            timer: 2000,
                        }).then((value) => {
                            var redirect_url = "{{ route('admin_purchase') }}"
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

        $('#type_id').on('change', function() {

            let typeId = $(this).val();

            $('#item').html('<option value="">Loading...</option>');

            if (typeId) {

                $.ajax({
                    url: '/items/by-type/' + typeId,
                    type: 'GET',
                    success: function(data) {

                        let options = '<option value="">Pilih Item</option>';

                        data.forEach(function(item) {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });

                        $('#item').html(options);
                    },
                    error: function() {
                        alert('Failed to load items');
                    }
                });

            } else {
                $('#item').html('<option value="">Pilih Item</option>');
            }

        });

        $('#item').on('change', function() {

            let itemId = $(this).val();

            $('#variant').html('<option value="">Loading...</option>');

            if (itemId) {

                $.ajax({
                    url: '/variants/by-item/' + itemId,
                    type: 'GET',
                    success: function(data) {

                        let options = '<option value="">Pilih Item</option>';

                        data.forEach(function(item) {
                            options += `<option value="${item.id}" data-price="${item.price}">${item.color + " Ukuran " + item.size_label}</option>`;
                        });

                        $('#variant').html(options);
                    },
                    error: function() {
                        alert('Failed to load items');
                    }
                });

            } else {
                $('#variant').html('<option value="">Pilih Item</option>');
            }

        });

        $('#variant').on('change', function() {

            let price = $(this).find(':selected').data('price');

            if (price) {
                $('#price').text("Harga Rp " +
                    new Intl.NumberFormat('id-ID').format(price)
                );
            }

        });

        let rowIndex = 0;

        $('#btnAdd').on('click', function() {

            let typeText = $('#type_id option:selected').text();
            let itemText = $('#item option:selected').text();
            let variantText = $('#variant option:selected').text();
            let variantId = $('#variant').val();
            let qty = $('#qty').val();
            let price = $('#variant option:selected').data('price');

            if (!variantId) {
                alert('Please select variant');
                return;
            }

            rowIndex++;

            price = price * qty
            let formattedPrice = new Intl.NumberFormat('id-ID').format(price);

            let row = `
            <tr id="row${rowIndex}">
            <td>${itemText}</td>
            <td>${variantText}</td>
            <td>Rp ${formattedPrice}</td>
            <td>${qty}</td>
            <td>
                <button type="button" 
                    class="btn btn-sm btn-danger"
                    onclick="removeRow(${rowIndex})">
                    Remove
                </button>
            </td>

            <input type="hidden" name="items[${rowIndex}][variant_id]" value="${variantId}">
            <input type="hidden" name="items[${rowIndex}][price]" value="${price}">
            <input type="hidden" name="items[${rowIndex}][qty]" value="${qty}">
            </tr>
            `;

            $('#purchaseTable').append(row);




        });

    });
</script>
@endpush