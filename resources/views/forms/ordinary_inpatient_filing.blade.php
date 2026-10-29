{{-- Medical certificate (inpatient), filing cases: confined from a date to present. --}}
<div class="cert-form">
    @include('forms.partials.head', [
        'title' => 'Medical certificate · Inpatient filing cases', 'icon' => 'folder2-open', 'lock_issued' => true,
    ])
    <div class="row g-3">
        <div class="col-lg-7">
            @include('forms.partials.patient')
            @include('forms.partials.visit', [
                'heading' => 'Confinement', 'from_label' => 'Examined / confined from',
                'to' => 'present_sync', 'to_label' => 'To',
            ])
            @include('forms.partials.items', [
                'list_id' => 'diagnosis_list', 'heading' => 'Working impression', 'icon' => 'clipboard2-pulse',
                'trigger' => 'btn_add_diagnosis', 'items' => $diagnosis ?? null, 'field' => 'diagnosis',
                'edit_fn' => 'editDiagnosis', 'delete_fn' => 'deleteDiagnosis', 'required' => true,
                'empty_text' => 'No working impression yet. Click Add to enter one.',
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
