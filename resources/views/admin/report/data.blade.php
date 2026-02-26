<table class="table table-borderless table-hover my-2">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Nama</strong></th>
            <th scope="col">Kelas</strong></th>
            <th scope="col">Tanggal Dibuat</strong></th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quiz as $key => $data)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $data->name }}</td>
            <td>{{ $data->Class?->name }}</td>
            <td>{{ $data->created_at }}</td>
            <td>
                <div class="d-flex justify-content">
                    <a class="dropdown-item" href="{{ route('admin_report_view', $data->id) }}" ><i class="bi bi-eye"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $quiz->links('components.paginate') }}