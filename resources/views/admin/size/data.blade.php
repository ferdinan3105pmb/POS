<table class="table table-borderless table-hover my-2">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Name</strong></th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sizes as $key => $data)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $data->name }}</td>
            <td>
                <div class="d-flex justify-content">
                    <a class="dropdown-item" href="{{ route('admin_edit_size', $data->id) }}"><i class="bi bi-pencil-square"></i></a>
                    <a class="dropdown-item" href="#" onclick="deleteData({{ $data->id }})"><i class="bi bi-trash"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $sizes->links('components.paginate') }}