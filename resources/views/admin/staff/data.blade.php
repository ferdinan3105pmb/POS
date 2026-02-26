<table class="table table-borderless table-hover my-2">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Email</strong></th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($staffs as $key => $staff)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $staff->email }}</td>
            <td>
                <div class="d-flex justify-content">
                    <a class="dropdown-item" href="{{ route('admin_edit_user', $staff->id) }}"><i class="bi bi-pencil-square"></i></a>
                    <a class="dropdown-item" href="#" onclick="deleteData({{ $staff->id }})"><i class="bi bi-trash"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $staffs->links('components.paginate') }}