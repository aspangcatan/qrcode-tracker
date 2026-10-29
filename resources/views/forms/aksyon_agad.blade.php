{{-- Aksyon Agad certification (ER/OPD). Free of charge, so payment stays hidden. --}}
<div class="cert-form">
    @include('forms.partials.head', ['title' => 'Aksyon Agad · ER/OPD', 'icon' => 'lightning-charge'])
    <div class="row g-3">
        <div class="col-lg-7">
            @include('forms.partials.patient', ['with_sex' => true])
            @include('forms.partials.visit', [
                'heading' => 'Consultation', 'from_label' => 'Examined and treated / confined on',
            ])
            @include('forms.partials.items', [
                'list_id' => 'diagnosis_list', 'heading' => 'Diagnosis', 'icon' => 'clipboard2-pulse',
                'trigger' => 'btn_add_diagnosis', 'items' => $diagnosis ?? null, 'field' => 'diagnosis',
                'edit_fn' => 'editDiagnosis', 'delete_fn' => 'deleteDiagnosis', 'required' => true,
                'empty_text' => 'No diagnosis yet. Click Add to enter one.',
            ])
        </div>
        <div class="col-lg-5">
            @include('forms.partials.physician')
            @include('forms.partials.request', ['purpose' => 'select', 'second_options' => ['(AKSYON AGAD)']])
            @include('forms.partials.billing', ['hidden' => true])
        </div>
    </div>
</div>
