@section('title', 'Quiz')

@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none">
    <a href="/dashboard"><h1 style="margin-left:20px !important;font-size:20px;margin-bottom:14px">Dashboard</h1></a>
</div>
@endsection

@extends('main')

@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="class-md-12">
            @if (isset($message))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
            @endif

            <div class="col-md-12">
                <button class="btn btn-primary mb-2" type="button" data-toggle="collapse" data-target="#listContent" aria-expanded="false" aria-controls="listContent">
                    Quiz Untuk Dikerjakan
                </button>

                <div class="collapse show" id="listContent">
                    <ul class="list-group">
                        @foreach($datas as $data)
                        <li class="list-group-item list-quiz"><a href="{{ route('quiz_index', $data->id) }}">{{$data->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary my-2" type="button" data-toggle="collapse" data-target="#listContent2" aria-expanded="false" aria-controls="listContent">
                    Quiz Yang Telah Dikerjakan
                </button>

                <div class="collapse show my-2" id="listContent2">
                    <ul class="list-group">
                        @foreach($done_test as $data)
                        <li class="list-group-item"><a href="{{ route('quiz_view_result', $data->id) }}">{{$data->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
@endpush