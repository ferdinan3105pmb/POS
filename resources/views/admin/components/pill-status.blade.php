@if ($value == 0)
    <span class="badge px-4"
        style="border-radius: 30px; background-color:#e6e6e6; color:#545454;padding-top:0.7rem;padding-bottom:0.7rem;font-weight:500;font-size:95%">{{ $slot }}</span>
@elseif($value == 1)
    <span class="badge px-4"
        style="border-radius: 30px; background-color:#faf9eb; color:#c7b40e;padding-top:0.7rem;padding-bottom:0.7rem;font-weight:500;font-size:95%">{{ $slot }}</span>
@elseif($value == 2)
    <span class="badge px-4"
        style="border-radius: 30px; background-color:#ebfaf2; color:#0ec7b0;padding-top:0.7rem;padding-bottom:0.7rem;font-weight:500;font-size:95%">{{ $slot }}</span>
@else
    <span class="badge px-4"
        style="border-radius: 30px; background-color:#fff0f2; color:#e46a76;padding-top:0.7rem;padding-bottom:0.7rem;font-weight:500;font-size:95%">{{ $slot }}</span>
@endif
