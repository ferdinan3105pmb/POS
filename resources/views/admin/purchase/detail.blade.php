@section('title', 'Admin')
@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none" style="margin-left:30px">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/admin/purchase') }}">Purchase</a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
</div>
@endsection
@extends('admin.main')
@section('content')
<section class="section dashboard">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body mt-4 px-4">
                <div class="col-md-12 my-2">
                    <label for="qty" class="form-label">Date</label>
                    <input type="datetime" name="date" id="date" class="form-control" value="{{$purchase->date}}" readonly>
                </div>

                <div class="col-md-12 my-2">
                    <label for="qty" class="form-label">Total</label>
                    <input type="text" name="total" id="total" class="form-control" value="RP. {{$purchase->total}}" readonly>
                </div>
            </div>
        </div>

        <div class="card my-2">
            <div class="card-body mt-4 px-4">
                <h2>Daftar Pembelian</h2>
                <table class="table table-borderless table-hover my-2">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Variant</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseTable">
                        @foreach($purchase->Detail as $data)
                        <td>{{$data->ItemVariant->Item->name}}</td>
                        <td>Warna {{$data->ItemVariant->color}}, Ukuran {{$data->ItemVariant->sizeLabel}}</td>
                        <td>{{$data->qty}}</td>
                        <td>{{format_idr($data->ItemVariant->price)}}</td>
                    </tbody>
                    @endforeach
                </table>
            </div>

            <div class="mb-3" style="display: flex; justify-content: flex-end;">
                <div class="mx-2">
                    <a href="{{ route('admin_purchase') }}" class="btn-submit px-4 btn btn-sm btn-dark rounded-pill float-right ml-3">
                        Cancel</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection