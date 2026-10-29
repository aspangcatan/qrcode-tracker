{{-- Medical abstract: admission details and the clinical lists. --}}
<div class="cert-form">
    @include('forms.partials.head', ['title' => 'Medical abstract', 'icon' => 'journal-medical', 'lock_issued' => true])
    <div class="row g-3">
        <div class="col-lg-7">
            @include('forms.partials.patient', ['with_sex' => true, 'with_ward' => true])
            @include('forms.partials.visit', [
                'heading' => 'Admission', 'from_label' => 'Date admitted', 'from_type' => 'datetime-local',
            ])
            @include('forms.partials.items', [
                'list_id' => 'chief_complaint_list', 'heading' => 'Chief complaint / history of present illness',
                'icon' => 'chat-left-text', 'trigger' => 'btn_add_chief_complaint',
                'items' => $chief_complaints ?? null, 'field' => 'chief_complaint',
                'edit_fn' => 'editListItem', 'delete_fn' => 'deleteListItem',
                'empty_text' => 'No chief complaint yet.',
            ])
            @include('forms.partials.items', [
                'list_id' => 'diagnosis_list', 'heading' => 'Diagnosis', 'icon' => 'clipboard2-pulse',
                'trigger' => 'btn_add_diagnosis', 'items' => $diagnosis ?? null, 'field' => 'diagnosis',
                'edit_fn' => 'editDiagnosis', 'delete_fn' => 'deleteDiagnosis',
                'empty_text' => 'No diagnosis yet.',
            ])
            @include('forms.partials.items', [
                'list_id' => 'medication_list', 'heading' => 'Medication on board', 'icon' => 'capsule',
                'trigger' => 'btn_add_medication', 'items' => $medications ?? null, 'field' => 'medication',
                'edit_fn' => 'editListItem', 'delete_fn' => 'deleteListItem',
                'empty_text' => 'No medication yet.',
            ])
            @include('forms.partials.items', [
                'list_id' => 'plan_list', 'heading' => 'Plan', 'icon' => 'signpost-split',
                'trigger' => 'btn_add_plan', 'items' => $plans ?? null, 'field' => 'plan',
                'edit_fn' => 'editListItem', 'delete_fn' => 'deleteListItem',
                'empty_text' => 'No plan yet.',
            ])
        </div>
        <div class="col-lg-5">
            @include('forms.partials.physician', ['with_designation' => true])
            @include('forms.partials.billing', [
                'amount_default' => isset($amount) ? number_format($amount, 2, '.', '') : null,
            ])
        </div>
    </div>
</div>
