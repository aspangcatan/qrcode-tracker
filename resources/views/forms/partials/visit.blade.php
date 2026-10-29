{{--
    When the patient was seen or confined.
    Params: $heading, $from_label, $from_type ('date' | 'datetime-local'),
            $to (null | 'date' | 'present' | 'present_sync'), $to_label, $required.
    'present_sync' keeps a hidden #date_discharged equal to #date_examined (filing cases).
--}}
@php
    $c = (isset($certificates) && $certificates) ? $certificates : null;
    $from_type = $from_type ?? 'date';
    $to = $to ?? null;
    $from_value = '';
    if ($c) {
        $from_value = $from_type === 'date'
            ? \Illuminate\Support\Carbon::parse($c->date_examined)->format('Y-m-d')
            : $c->date_examined;
    }
@endphp
<section class="form-section">
    <h6 class="section-title"><i class="bi bi-calendar-event"></i> {{ $heading ?? 'Visit' }}</h6>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label" for="date_examined">{{ $from_label }} @if($required ?? false)<span class="req">*</span>@endif</label>
            <input type="{{ $from_type }}" class="form-control" id="date_examined" value="{{ $from_value }}"
                   @if($to === 'present_sync') onchange="document.getElementById('date_discharged').value = this.value" @endif/>
        </div>
        @if($to === 'date')
            <div class="col-md-6">
                <label class="form-label" for="date_discharged">{{ $to_label ?? 'To' }}</label>
                <input type="date" class="form-control" id="date_discharged"
                       value="{{ $c ? \Illuminate\Support\Carbon::parse($c->date_discharged)->format('Y-m-d') : '' }}"/>
            </div>
        @elseif($to === 'present' || $to === 'present_sync')
            <div class="col-md-6">
                <span class="form-label d-block">{{ $to_label ?? 'To' }}</span>
                <div class="static-value"><i class="bi bi-hourglass-split"></i> Present</div>
                @if($to === 'present_sync')
                    <input type="hidden" id="date_discharged"
                           value="{{ $c ? \Illuminate\Support\Carbon::parse($c->date_examined)->format('Y-m-d') : '' }}"/>
                @endif
            </div>
        @endif
    </div>
</section>
