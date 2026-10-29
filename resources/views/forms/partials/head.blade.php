{{--
    Certificate header: type, certificate no., hospital no. and date issued.
    Params: $title, $icon, $lock_issued (date issued stays disabled when editing).
--}}
@php
    $c = (isset($certificates) && $certificates) ? $certificates : null;
@endphp
<div class="cert-head">
    <div class="cert-kind">
        <span class="cert-kind-icon"><i class="bi bi-{{ $icon ?? 'file-earmark-medical' }}"></i></span>
        <div>
            <p class="eyebrow">{{ $c ? 'Editing certificate' : 'New certificate' }}</p>
            <h4 class="cert-title">{{ $title }}</h4>
        </div>
    </div>
    <div class="cert-meta">
        <div class="cert-meta-item">
            <label class="info-label" for="certificate_no">Certificate No.</label>
            @if($c)
                <input type="text" class="form-control" id="certificate_no" value="{{ $c->certificate_no }}" disabled/>
            @elseif(isset($certificate_no) && $certificate_no)
                <input type="text" class="form-control" id="certificate_no" value="{{ $certificate_no }}" disabled/>
            @endif
        </div>
        <div class="cert-meta-item">
            <label class="info-label" for="health_record_no">Hospital No. <span class="req">*</span></label>
            <input type="text" class="form-control" id="health_record_no" value="{{ $c ? $c->health_record_no : '' }}"/>
        </div>
        <div class="cert-meta-item">
            <label class="info-label" for="date_issued">Date</label>
            @if($c)
                <input type="date" class="form-control" id="date_issued"
                       value="{{ date('Y-m-d', strtotime($c->created_at)) }}" @if($lock_issued ?? false) disabled @endif/>
            @else
                <input type="date" class="form-control" id="date_issued" value="{{ now()->format('Y-m-d') }}" disabled/>
            @endif
        </div>
    </div>
</div>
