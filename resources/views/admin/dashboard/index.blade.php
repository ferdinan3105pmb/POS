@section('title', 'Admin')

@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none">
    <h1 style="margin-left:20px !important;font-size:20px;margin-bottom:14px">Dashboard</h1>
</div>
@endsection

@extends('admin.main')

@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">

            <h1>Welcome Admin</h1>

        </div>
    </div>
</section>
@endsection
@push('js')

@endpush