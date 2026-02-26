@if(isset($item))
@foreach($item as $key=>$data)
<table class="table table-borderless table-hover my-2">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Warna</strong></th>
            <th scope="col">Harga</strong></th>
            <th scope="col">Ukuran</strong></th>
            <th scope="col">Stok</strong></th>
            <th scope="col">Aksi</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($item as $key => $data)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $data->color }}</td>
            <td>{{ $data->price }}</td>
            <td>{{ $data->Size->name }}</td>
            <td>{{ $data->stock }}</td>
            <td><button type="button" class="btn btn-primary edit-option-btn" id="edit-option-btn" data-id="{{ $data->id }}" data-bs-target="#EditOptionModal">
                    Edit
                </button></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach
@endif