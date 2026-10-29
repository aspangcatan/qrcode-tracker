{{--
    Payment and release tracking. js/home shows #no_copies_container for new certificates.
    Params: $amount_default (new certificates), $amount_locked, $hidden.
--}}
@php
    $c = (isset($certificates) && $certificates) ? $certificates : null;
@endphp
<section class="form-section @if($hidden ?? false) d-none @endif">
    <h6 class="section-title"><i class="bi bi-receipt"></i> Payment &amp; release</h6>
    <div class="row g-3">
        <div class="col-sm-6">
            <label class="form-label" for="or_no">OR No.</label>
            <input type="text" class="form-control" id="or_no" value="{{ $c ? $c->or_no : '' }}"/>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="amount">Amount <span class="req">*</span></label>
            <div class="input-group">
                <span class="input-group-text">₱</span>
                <input type="text" class="form-control" id="amount"
                       value="{{ $c ? $c->amount : ($amount_default ?? '') }}" @if($amount_locked ?? false) disabled @endif/>
            </div>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="charge_slip_no">Charge slip No. <span class="req">*</span></label>
            <input type="text" class="form-control" id="charge_slip_no" value="{{ $c ? $c->charge_slip_no : '' }}"/>
        </div>
        <div class="col-sm-6 d-none">
            <label class="form-label" for="registry_no">Registry No.</label>
            <input type="text" class="form-control" id="registry_no" value="{{ $c ? $c->registry_no : '' }}" disabled/>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="date_requested">Date/time requested <span class="req">*</span></label>
            <input type="datetime-local" class="form-control" id="date_requested"
                   value="{{ $c ? $c->date_requested : now()->format('Y-m-d\TH:i') }}"/>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="date_finished">Date/time finished</label>
            <input type="datetime-local" class="form-control" id="date_finished"
                   value="{{ $c ? $c->date_completed : '' }}" disabled/>
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="received_by">Received by <span class="req">*</span></label>
            <select class="js-example-basic-single w-100" id="received_by">
                <option></option>
                @foreach($receivers as $receiver)
                    <option @if($c && $c->received_by === $receiver->name) selected @endif>{{ $receiver->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6 d-none" id="no_copies_container">
            <label class="form-label" for="no_copies">Number of copies</label>
            <select class="form-select" id="no_copies">
                @for($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>
</section>
