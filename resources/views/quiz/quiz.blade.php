@section('title', 'Quiz')
@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none">
    <a href="/dashboard"><h1 style="margin-left:20px !important;font-size:20px;margin-bottom:14px">Dashboard</h1></a>
</div>
@endsection

@extends('main')
@section('content')
<section class="section dashboard">
    @if($parent->timer != NULL && $parent->timer > 0.0)
    <div class="alert alert-info text-center">
        Time Remaining: <span id="timer">--:--</span>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="question-number">
                @for ($i = 0; $i < $count; $i++)
                    <button class="btn btn-outline-primary section-btn" onclick="scrollToSection('section{{$i}}')">{{$i+1}}</button>
                    @endfor
            </div>
            <form id="formData" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf
                @foreach($datas as $key=>$data)
                <div class="card mb-3">
                    <div class="card-body quiz-description" id="section{{$key}}">
                        <p><strong>{{$key+1}} . {{ $data->question }}</strong></p>

                        @if(!empty($data->Choices) && is_iterable($data->Choices))
                        @foreach($data->Choices as $index => $choice)
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="{{ $data->id }}"
                                id="choice_{{ $data->id }}_{{ $index }}"
                                value="{{ $choice->id }}">
                            <label class="form-check-label" for="choice_{{ $data->id }}_{{ $index }}">
                                {{ $choice->description }}
                            </label>
                        </div>
                        @endforeach
                        @else
                        <p class="text-muted">No choices available.</p>
                        @endif
                    </div>
                </div>
                @endforeach

                <div class="mb-3" style="display: flex; justify-content: flex-end;">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border mt-2" role="status" style="display:none;margin-bottom:-90px; margin-right:15px">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="submit btn-submit px-4 btn btn-sm btn-dark rounded-pill float-right ml-3">
                            Submit</button>
                    </div>
                    <div class="mx-2">
                        <a href="{{ route('dashboard') }}" class="btn-cancel px-4 btn btn-sm rounded-pill float-right ml-3">
                            Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@push('css')
<script>
    let countdown = null;
    const timeout = @json($parent->timer);

    console.log(timeout);

    function scrollToSection(id) {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const radios = document.querySelectorAll("input[type=radio]");

        // Load saved values
        radios.forEach(radio => {
            const saved = localStorage.getItem(radio.name);
            if (saved && radio.value === saved) {
                radio.checked = true;
            }
        });

        // Save value on change
        radios.forEach(radio => {
            radio.addEventListener("change", function() {
                localStorage.setItem(this.name, this.value);
            });
        });
    });

    if (timeout > 0) {
        // === CONFIGURE YOUR QUIZ TIME HERE (in seconds) ===
        document.addEventListener("DOMContentLoaded", function() {
            console.log(timeout);
            const totalSeconds = 60 * timeout;
            let remaining = totalSeconds;

            const timerEl = document.getElementById('timer');
            const form = document.getElementById('formData');
            const radios = document.querySelectorAll("input[type=radio]");

            function updateTimerDisplay() {
                const minutes = String(Math.floor(remaining / 60)).padStart(2, '0');
                const seconds = String(remaining % 60).padStart(2, '0');
                timerEl.textContent = `${minutes}:${seconds}`;
            }

            countdown = setInterval(() => {
                if (remaining <= 0) {
                    clearInterval(countdown);
                    disableQuiz();
                    showTimeUpPopup();
                } else {
                    remaining--;
                    updateTimerDisplay();
                }
            }, 1000);

            function disableQuiz() {
                radios.forEach(radio => radio.setAttribute('readonly', true));
            }

            function showTimeUpPopup() {
                swal({
                    title: "Time is up!",
                    text: "Your time is over. Please submit your answer.",
                    icon: "warning",
                    buttons: {
                        confirm: {
                            text: "Submit",
                            closeModal: false
                        }
                    },
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then(() => {
                    $('#formData').submit();
                });
            }

            updateTimerDisplay(); // Show initial time
        });
    }


    $(document).ready(function() {
    $('#formData').on('submit', function(e) {
        e.preventDefault();

        // Show confirmation popup first
        swal({
            title: 'Submit Jawaban ?',
            text: "Pastikan semua jawaban sudah benar.",
            icon: 'warning',
            buttons: true,
        }).then((result) => {
            if (result) {
                if (timeout > 0) {
                    clearInterval(countdown);
                }
                // Remove localStorage answers
                const radios = document.querySelectorAll("input[type=radio]");
                const uniqueNames = [...new Set([...radios].map(r => r.name))];
                uniqueNames.forEach(name => localStorage.removeItem(name));

                $('.spinner-border').show();
                $(".submit").prop('disabled', true);
                $('.is-invalid').each(function() {
                    $('.is-invalid').removeClass('is-invalid');
                });

                var formData = new FormData($('#formData')[0]);
                $.ajax({
                    url: "{{ route('quiz_grade', $id) }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $('.spinner-border').hide();
                        if (res.status) {
                            swal("Success", "Score Anda: " + res.message, "success").then(() => {
                                window.location.href = "{{ route('dashboard') }}";
                            });
                        } else {
                            toastr['error'](res.error);
                        }
                    },
                    error: function(res) {
                        $('.spinner-border').hide();
                        $(".submit").prop('disabled', false);
                        if (res.status != 422)
                            toastr['error']("Something went wrong");
                        showError(res.responseJSON.errors, "#formData");
                    }
                });
            }
        });

        return false;
    });
});

</script>
@endpush