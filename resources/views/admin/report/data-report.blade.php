<table class="table table-borderless table-hover my-2">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Nama</strong></th>
            <th scope="col">Nilai</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $key => $report)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $report->User?->name }}</td>
            <td>{{ $report->grade }}</td>
        </tr>
        @endforeach
    </tbody>
</table>