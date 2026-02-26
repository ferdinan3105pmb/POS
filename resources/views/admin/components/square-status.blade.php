@if ($value == 0)
    <i class="fas fa-circle"
        style="color:#fec90f; text-shadow: 0 0 10px #fae271, 0 0 13px #fae271;font-size:11px;margin-right:5px"></i>
    <span style="color:#fec90f">{{ $slot }}</span>
@elseif($value == 1)
    <i class="fas fa-circle"
        style="color:#3dae76; text-shadow: 0 0 10px #69fdb3, 0 0 13px #69fdb3;font-size:11px;margin-right:5px"></i>
    <span style="color:#3dae76">{{ $slot }}</span>
@elseif($value == 2)
    <i class="fas fa-circle"
        style="color:#1d2453; text-shadow: 0 0 10px #2e3873, 0 0 13px #2e3873;font-size:11px;margin-right:5px"></i>
    <span style="color:#1d2453">{{ $slot }}</span>
@else
    <i class="fas fa-circle"
        style="color:#e46a76; text-shadow: 0 0 10px #ffa6ae, 0 0 13px #ffa6ae;font-size:11px;margin-right:5px"></i>
    <span style="color:#e46a76">{{ $slot }}</span>
@endif
