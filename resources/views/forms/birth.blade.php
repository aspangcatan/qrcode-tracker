{{--
    Birth certification. Baby's name, gender, address, informant, relationship, doctor (chosen from HOMIS via
    forms.partials.physician) and OR No. use the
    certificates table; the rest lives in birth_details (js/home sends it as "birth").
    js/home shows #parents_status_container only for NEW and RETYPE transactions.
--}}
@php
$c = (isset($certificates) && $certificates) ? $certificates : null;
$b = (isset($birth) && $birth) ? $birth : null;
$sex = $c ? strtoupper($c->sex) : '';
$transactions = ['NEW', 'RETYPE', 'IMMUNIZATION CARD RE-ISSUANCE'];
$with_status = ['NEW', 'RETYPE'];
$parent_statuses = ['MARRIED', 'SINGLE', 'SINGLE MARRIED','NOT MARRIED W/ CEDULA', 'NOT MARRIED W/OUT CEDULA'];
$transaction = $b ? $b->transaction : '';
// Not stored: an existing record counts as "same" when the informant is the mother and the relationship says so.
$informant_is_mother = $c && $b && $b->mother_name
    && strcasecmp(trim($c->requesting_person), trim($b->mother_name)) === 0
    && strcasecmp(trim($c->relationship), 'MOTHER') === 0;
@endphp
<div class="cert-form">
    @include('forms.partials.head', [
    'title' => 'Birth certification', 'icon' => 'balloon-heart', 'lock_issued' => true,
    'hrn_label' => "Child's hospital No.",
    ])
    <div class="row g-3">
        <div class="col-lg-7">
            <section class="form-section">
                <h6 class="section-title"><i class="bi bi-list-check"></i> Transaction</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="transaction">Birth certification <span class="req">*</span></label>
                        <select class="form-select" id="transaction">
                            <option></option>
                            @foreach($transactions as $option)
                            <option @if($transaction==$option) selected @endif>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 @unless(in_array($transaction, $with_status)) d-none @endunless" id="parents_status_container">
                        <label class="form-label" for="parents_status">Parents' status <span class="req">*</span></label>
                        <select class="form-select" id="parents_status">
                            <option></option>
                            @foreach($parent_statuses as $option)
                            <option @if($b && $b->parents_status == $option) selected @endif>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <section class="form-section">
                <h6 class="section-title"><i class="bi bi-person"></i> Baby</h6>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="patient">Baby's name <span class="req">*</span></label>
                        <input type="text" class="form-control" id="patient" placeholder="Last name, First name M.I."
                            value="{{ $c ? $c->patient : '' }}" />
                    </div>
                    <div class="col-6 col-md-4">
                        <label class="form-label" for="sex">Gender <span class="req">*</span></label>
                        <select class="form-select" id="sex">
                            <option></option>
                            <option @if($sex=='MALE' ) selected @endif>MALE</option>
                            <option @if($sex=='FEMALE' ) selected @endif>FEMALE</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-4">
                        <label class="form-label" for="date_of_birth">Date of birth <span class="req">*</span></label>
                        <input type="date" class="form-control" id="date_of_birth" value="{{ $b ? $b->date_of_birth : '' }}" />
                    </div>
                    <div class="col-6 col-md-4">
                        <label class="form-label" for="time_of_birth">Time of birth</label>
                        <input type="time" class="form-control" id="time_of_birth"
                            value="{{ ($b && $b->time_of_birth) ? substr($b->time_of_birth, 0, 5) : '' }}" />
                    </div>
                    <div class="col-6 col-md-4">
                        <label class="form-label" for="weight">Weight</label>
                        <input type="text" class="form-control" id="weight" placeholder="e.g. 3.2 KG"
                            value="{{ $b ? $b->weight : '' }}" />
                    </div>
                </div>
            </section>

            {{-- Same HOMIS physician chooser as the medical certificates. --}}
            @include('forms.partials.physician', ['with_designation' => true])

            <section class="form-section">
                <h6 class="section-title"><i class="bi bi-people"></i> Mother &amp; informant</h6>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="mother_name">Mother's name <span class="req">*</span></label>
                        <input type="text" class="form-control" id="mother_name" placeholder="Last name, First name M.I."
                            value="{{ $b ? $b->mother_name : '' }}" />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="cell_no">Cell No.</label>
                        <input type="tel" class="form-control" id="cell_no" placeholder="09XX XXX XXXX"
                            value="{{ $b ? $b->cell_no : '' }}" />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="address">Address <span class="req">*</span></label>
                        <input type="text" class="form-control" id="address" placeholder="Street, Barangay, City / Municipality"
                            value="{{ $c ? $c->address : '' }}" />
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="informant_is_mother"
                                @if($informant_is_mother) checked @endif />
                            <label class="form-check-label" for="informant_is_mother">INFORMANT AND MOTHER THE SAME</label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label" for="requesting_person">Informant <span class="req">*</span></label>
                        <input type="text" class="form-control" id="requesting_person" placeholder="Name of informant"
                            value="{{ $c ? $c->requesting_person : '' }}" @if($informant_is_mother) readonly @endif />
                    </div>
                    <div class="col-md-5">
                        <label class="form-label" for="relationship">Relationship</label>
                        <input type="text" class="form-control" id="relationship" placeholder="e.g. Mother, Father"
                            value="{{ $c ? $c->relationship : '' }}" @if($informant_is_mother) readonly @endif />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="authorized_person">Authorized person</label>
                        <input type="text" class="form-control" id="authorized_person"
                            placeholder="Person authorized to claim, if not the informant"
                            value="{{ $b ? $b->authorized_person : '' }}" />
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-5">
            @include('forms.partials.billing')

            <section class="form-section">
                <h6 class="section-title"><i class="bi bi-box-arrow-up-right"></i> Receiving &amp; release</h6>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="date_received">Date received</label>
                        <input type="date" class="form-control" id="date_received" value="{{ $b ? $b->date_received : '' }}" />
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="date_claimed">Date claimed</label>
                        <input type="date" class="form-control" id="date_claimed" value="{{ $b ? $b->date_claimed : '' }}" />
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="date_released">Date/time released</label>
                        <input type="datetime-local" class="form-control" id="date_released"
                            value="{{ $c ? $c->date_issued : '' }}" disabled />
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="released_by">Released by</label>
                        <input type="text" class="form-control" id="released_by" value="{{ $c ? $c->released_by : '' }}" disabled />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="prepared_by">Prepared by</label>
                        <input type="text" class="form-control" id="prepared_by"
                            value="{{ $c ? $c->prepared_by : strtoupper(trim(auth()->user()->fname . ' ' . (auth()->user()->mname ? auth()->user()->mname[0] . '.' : '') . ' ' . auth()->user()->lname)) }}"
                            disabled />
                    </div>
                </div>
                <div class="form-text">Prepared by, released by and date released are filled in automatically when the record is saved and tagged.</div>
            </section>
        </div>
    </div>
</div>