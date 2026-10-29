{{--
    Attending physician, filled by the "Select physician" dialog (js/home sets these by id).
    Params: $with_designation, $required, $hidden.
--}}
@php
    $c = (isset($certificates) && $certificates) ? $certificates : null;
@endphp
<section class="form-section @if($hidden ?? false) d-none @endif">
    <div class="section-head">
        <h6 class="section-title"><i class="bi bi-person-badge"></i> Attending physician @if($required ?? false)<span class="req">*</span>@endif</h6>
        <button type="button" class="btn btn-sm btn-tonal" onclick="document.getElementById('btn_add_doctor').click()">
            <i class="bi bi-search"></i> Choose
        </button>
    </div>
    <div class="row g-3">
        <div class="col-12">
            <label class="form-label" for="doctor">Name</label>
            <input type="text" class="form-control" id="doctor" placeholder="Choose a physician"
                   value="{{ $c ? $c->doctor : '' }}" disabled/>
        </div>
        @if($with_designation ?? false)
            <div class="col-sm-6">
                <label class="form-label" for="doctor_designation">Designation</label>
                <input type="text" class="form-control" id="doctor_designation"
                       value="{{ $c ? $c->doctor_designation : '' }}" disabled/>
            </div>
        @endif
        <div class="{{ ($with_designation ?? false) ? 'col-sm-6' : 'col-12' }}">
            <label class="form-label" for="doctor_license">License No.</label>
            <input type="text" class="form-control" id="doctor_license"
                   value="{{ $c ? $c->doctor_license : '' }}" disabled/>
        </div>
    </div>
</section>
