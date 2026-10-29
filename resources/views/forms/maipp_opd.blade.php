{{-- Presigned certification (OPD). --}}
<div class="cert-form">
    @include('forms.partials.head', ['title' => 'Presigned · OPD', 'icon' => 'pen'])
    <div class="row g-3">
        <div class="col-lg-7">
            @include('forms.partials.patient', ['with_sex' => true, 'sex_required' => true])
            @include('forms.partials.visit', [
                'heading' => 'Consultation', 'from_label' => 'Examined and treated / confined on', 'required' => true,
            ])
            @include('forms.partials.items', [
                'list_id' => 'diagnosis_list', 'heading' => 'Working impression', 'icon' => 'clipboard2-pulse',
                'trigger' => 'btn_add_diagnosis', 'items' => $diagnosis ?? null, 'field' => 'diagnosis',
                'edit_fn' => 'editDiagnosis', 'delete_fn' => 'deleteDiagnosis', 'required' => true,
                'empty_text' => 'No working impression yet. Click Add to enter one.',
            ])
        </div>
        <div class="col-lg-5">
            @include('forms.partials.physician', ['required' => true])
            @include('forms.partials.request', [
                'purpose' => 'select', 'second_options' => ['(AKSYON AGAD)', '(CSWD)', '(DSWD)', '(MAIPP)'],
            ])
            @include('forms.partials.billing', [
                'amount_default' => isset($amount) ? number_format($amount, 2, '.', '') : null,
            ])
        </div>
    </div>
</div>
