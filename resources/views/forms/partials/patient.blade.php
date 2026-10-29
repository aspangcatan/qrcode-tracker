{{--
    Patient details. Params: $with_sex, $sex_required, $with_civil_status, $with_ward.
--}}
@php
    $c = (isset($certificates) && $certificates) ? $certificates : null;
    $sex = $c ? strtoupper($c->sex) : '';
@endphp
<section class="form-section">
    <h6 class="section-title"><i class="bi bi-person"></i> Patient</h6>
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label" for="patient">Patient's name <span class="req">*</span></label>
            <input type="text" class="form-control" id="patient" placeholder="Last name, First name M.I."
                   value="{{ $c ? $c->patient : '' }}"/>
        </div>
        <div class="col-6 col-md-4">
            <label class="form-label" for="age">Age <span class="req">*</span></label>
            <input type="text" class="form-control" id="age" placeholder="e.g. 34" value="{{ $c ? $c->age : '' }}"/>
        </div>
        @if($with_sex ?? false)
            <div class="col-6 col-md-4">
                <label class="form-label" for="sex">Sex @if($sex_required ?? false)<span class="req">*</span>@endif</label>
                <select class="form-select" id="sex">
                    <option></option>
                    <option @if($sex == 'MALE') selected @endif>MALE</option>
                    <option @if($sex == 'FEMALE') selected @endif>FEMALE</option>
                </select>
            </div>
        @endif
        @if($with_civil_status ?? false)
            <div class="col-6 col-md-4">
                <label class="form-label" for="civil_status">Civil status <span class="req">*</span></label>
                <select class="form-select" id="civil_status">
                    @foreach(['SINGLE', 'MARRIED', 'CHILD', 'WIDOW/ER'] as $status)
                        <option @if($c && $c->civil_status == $status) selected @endif>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="{{ ($with_ward ?? false) ? 'col-md-8' : 'col-12' }}">
            <label class="form-label" for="address">Complete address <span class="req">*</span></label>
            <input type="text" class="form-control" id="address" placeholder="Street, Barangay, City / Municipality"
                   value="{{ $c ? $c->address : '' }}"/>
        </div>
        @if($with_ward ?? false)
            <div class="col-md-4">
                <label class="form-label" for="ward">Ward / Room</label>
                <input type="text" class="form-control" id="ward" value="{{ $c ? $c->ward : '' }}"/>
            </div>
        @endif
    </div>
</section>
