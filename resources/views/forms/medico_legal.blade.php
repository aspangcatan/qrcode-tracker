{{-- Medico-legal certificate: injury details and days of incapacity. --}}
@php
    $c = (isset($certificates) && $certificates) ? $certificates : null;
    $s = (isset($sustained) && $sustained) ? $sustained : null;
@endphp
<div class="cert-form">
    @include('forms.partials.head', ['title' => 'Medico-legal certificate', 'icon' => 'shield-check'])
    <div class="row g-3">
        <div class="col-lg-7">
            @include('forms.partials.patient', ['with_sex' => true, 'sex_required' => true, 'with_civil_status' => true])
            @include('forms.partials.visit', [
                'heading' => 'Examination', 'from_label' => 'Examined on', 'from_type' => 'datetime-local',
                'required' => true,
            ])

            <section class="form-section">
                <h6 class="section-title"><i class="bi bi-bandaid"></i> Injury sustained</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="noi">Nature of injury (NOI) <span class="req">*</span></label>
                        <input type="text" class="form-control" id="noi" value="{{ $s ? $s->noi : '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="poi">Place of injury (POI) <span class="req">*</span></label>
                        <input type="text" class="form-control" id="poi" value="{{ $s ? $s->poi : '' }}"/>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="doi">Date of injury (DOI) <span class="req">*</span></label>
                        <input type="date" class="form-control" id="doi" value="{{ $s ? $s->doi : '' }}"/>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="toi">Time of injury (TOI) <span class="req">*</span></label>
                        <input type="time" class="form-control" id="toi" value="{{ $s ? $s->toi : '' }}"/>
                    </div>
                </div>
            </section>

            @include('forms.partials.items', [
                'list_id' => 'diagnosis_list', 'heading' => 'Lesion / injury diagnosis', 'icon' => 'clipboard2-pulse',
                'trigger' => 'btn_add_diagnosis', 'items' => $diagnosis ?? null, 'field' => 'diagnosis',
                'edit_fn' => 'editDiagnosis', 'delete_fn' => 'deleteDiagnosis', 'required' => true,
                'empty_text' => 'No diagnosis yet. Click Add to enter one.',
            ])

            <section class="form-section">
                <h6 class="section-title"><i class="bi bi-hourglass-split"></i> Healing period</h6>
                <label class="form-label" for="days_barred">Incapacity or medical attention needed for</label>
                <div class="input-group days-input">
                    <input type="number" class="form-control" id="days_barred" placeholder="0"
                           value="{{ $c ? $c->days_barred : '' }}"/>
                    <span class="input-group-text">day/s</span>
                </div>
                <div class="form-text">Barring complications; otherwise the period of healing will vary accordingly.</div>
            </section>
        </div>
        <div class="col-lg-5">
            @include('forms.partials.physician', ['with_designation' => true, 'required' => true])
            @include('forms.partials.request', ['requester_required' => false])
            @include('forms.partials.billing', ['amount_default' => '150.00', 'amount_locked' => true])
        </div>
    </div>
</div>
