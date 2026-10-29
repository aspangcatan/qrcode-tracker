{{-- Aksyon Agad certification (inpatient). Free of charge: no payment fields. --}}
<div class="cert-form">
    @include('forms.partials.head', ['title' => 'Aksyon Agad · Inpatient', 'icon' => 'lightning-charge'])
    <div class="row g-3">
        <div class="col-lg-7">
            @include('forms.partials.patient', ['with_sex' => true])
            @include('forms.partials.visit', [
                'heading' => 'Confinement', 'from_label' => 'Examined and treated from', 'to' => 'date', 'to_label' => 'To',
            ])
            @include('forms.partials.items', [
                'list_id' => 'diagnosis_list', 'heading' => 'Working impression', 'icon' => 'clipboard2-pulse',
                'trigger' => 'btn_add_diagnosis', 'items' => $diagnosis ?? null, 'field' => 'diagnosis',
                'edit_fn' => 'editDiagnosis', 'delete_fn' => 'deleteDiagnosis', 'required' => true,
                'empty_text' => 'No working impression yet. Click Add to enter one.',
            ])
        </div>
        <div class="col-lg-5">
            @include('forms.partials.physician')
            @include('forms.partials.request', [
                'purpose' => 'select', 'second_options' => ['(AKSYON AGAD)', '(CSWD)', '(DSWD)', '(MAIPP)'],
                'second_blank_last' => true,
            ])
        </div>
    </div>
</div>
