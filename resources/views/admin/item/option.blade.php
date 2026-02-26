<form id="formOption" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{$variant->id}}">
    <div class="modal-body">

        <div class="mb-3">
            <label for="questionText" class="form-label">Color</label>
            <input type="text" name="color" class="form-control" id="color" value="{{$variant->color}}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" class="form-control" id="price" value="{{$variant->price}}" required>
        </div>

        <div class="mb-3">
            <label for="option" class="form-label">Pilih Size</label>
            <select name="size" class="form-control" required>
                <option value="">Pilih Size</option> <!-- Default option -->
                @foreach ($sizes as $key => $size)
                <option value="{{ $size->id }}" {{ $size->id == $variant->size_id ? 'selected' : '' }}>
                    {{ $size->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" id="stock" value="{{$variant->stock}}" required>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Variant</button>
    </div>
</form>
<script>
    $('#formOption').on('submit', function(e) {
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
            url: "{{ route('admin_update_variant') }}",
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
                    swal("Success", "Data Variant Berhasil Diubah!", "success", {
                        buttons: false,
                        timer: 2000,
                    }).then(() => {
                        // Replace `#EditOptionModal` with your actual modal ID
                        $('#EditOptionModal').modal('hide');
                        getData();
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
</script>