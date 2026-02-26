@if ($value == 0)
    <h5 style="background-color: #8B4040;" class="badge badge-pill badge-warning">Rejected</h5>
@elseif($value == 1)
    <h5 style="background-color:  #6B6B6B" class="badge badge-pill badge-warning">No approval yet</h5>
@elseif($value == 2)
    <h5 style="background-color: #43088E" class="badge badge-pill badge-warning">Waiting for approval</h5>
@elseif($value == 3)
    <h5 style="background-color: #4F00B2" class="badge badge-pill badge-warning">Approved</h5>
@elseif($value == 4)
    <h5 style="background-color: #DBB327"class="badge badge-pill badge-warning">OnProcess</h5>
@else
    <h5 style="background-color: #006E7F" class="badge badge-pill badge-warning">Done</h5>
@endif



