<table class="table table-borderless table-hover my-2">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Total</strong></th>
            <th scope="col">Tanggal</strong></th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchase as $key => $data)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $data->total }}</td>
            <td>{{ $data->created_at }}</td>
            <td>
                <div class="d-flex justify-content">
                    <a class="dropdown-item" href="{{ route('admin_detail_purchase', $data->id) }}" ><i class="bi bi-eye"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $purchase->links('components.paginate') }}