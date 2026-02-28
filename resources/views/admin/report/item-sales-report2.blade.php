<table class="table table-borderless table-hover my-2">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Product Name</strong></th>
            <th scope="col">Product Variant</strong></th>
            <th scope="col">Total Qty</strong></th>
            <th scope="col">Total Sales</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $key => $data)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $data->ItemVariant->Item->name }}</td>
            <td>{{ $data->ItemVariant->color }} Ukuran {{$data->ItemVariant->sizeLabel}}</td>
            <td>{{ $data->total_qty }}</td>
            <td>{{ format_idr($data->total_sales) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>