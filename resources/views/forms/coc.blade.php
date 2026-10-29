{{-- Certificate of confinement: confined from a date to present. --}}
<div class="cert-form">
    @include('forms.partials.head', [
        'title' => 'Certificate of confinement', 'icon' => 'hospital', 'lock_issued' => true,
    ])
    <div class="row g-3">
        <div class="col-lg-7">
            @include('forms.partials.patient')
            @include('forms.partials.visit', [
                'heading' => 'Confinement', 'from_label' => 'Confined from', 'to' => 'present', 'to_label' => 'To',
            ])
            @include('forms.partials.items', [
                'list_id' => 'diagnosis_list', 'heading' => 'Diagnosis', 'icon' => 'clipboard2-pulse',
                'trigger' => 'btn_add_diagnosis', 'items' => $diagnosis ?? null, 'field' => 'diagnosis',
                'edit_fn' => 'editDiagnosis', 'delete_fn' => 'deleteDiagnosis',
                'empty_text' => 'No diagnosis yet. Optional for this certificate.',
            ])
        </div>
        <div class="col-lg-5">
            @include('forms.partials.physician', ['with_designation' => true])
            @include('forms.partials.request', ['purpose' => 'text'])
            @include('forms.partials.billing', [
                'amount_default' => isset($amount) ? number_format($amount, 2, '.', '') : null,
            ])
        </div>
    </div>
</div>
