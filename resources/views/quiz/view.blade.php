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
        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                Nilai Anda {{$grade}}
            </div>
            @for ($i = 0; $i < $count; $i++)
                <button class="btn btn-outline-primary section-btn" onclick="scrollToSection('section{{$i}}')">{{$i+1}}</button>
                @endfor


                @foreach($quiz->Question as $key=>$data)
                <div class="card mb-3">
                    <div class="card-body quiz-description" id="section{{$key}}">
                        <p><strong>{{$key+1}} . {{ $data->question }}</strong></p>

                        @foreach($data->Choices as $key => $choice)
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="choice_{{ $data->id }}"
                                value="{{ $choice->id }}" @if ($choice->id == $data->user_answer) checked @endif disabled>

                            <label class="form-check-label option-custom">
                                {{ $choice->description }}

                                @if ($choice->id == $data->user_answer)
                                <span class="badge bg-primary ms-2">Your Answer</span>
                                @endif

                                @if ($choice->id == $data->answer_id)
                                <span class="badge bg-success ms-2">Correct Answer</span>
                                @endif
                            </label>
                        </div>
                        @endforeach

                    </div>
                </div>
                @endforeach

                <div class="mb-3" style="display: flex; justify-content: flex-end;">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border mt-2" role="status" style="display:none;margin-bottom:-90px; margin-right:15px">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="mx-2">
                        <a href="{{ route('dashboard') }}" class="btn-submit px-4 btn btn-sm  btn-dark rounded-pill float-right ml-3">
                            Back</a>
                    </div>
                </div>
        </div>
    </div>
</section>
@endsection
@push('css')
<script>
    function scrollToSection(id) {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
</script>
@endpush