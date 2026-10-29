{{-- Ordinary medical certificate (ER/OPD); also the dental certificate. --}}
@php $dental = ($title ?? '') === 'DENTAL CERTIFICATE'; @endphp
<div class="cert-form">
    @include('forms.partials.head', [
        'title' => $dental ? 'Dental certificate' : 'Medical certificate · ER/OPD',
        'icon' => $dental ? 'emoji-smile' : 'file-earmark-medical',
        'lock_issued' => true,
    ])
    <div class="row g-3">
        <div class="col-lg-7">
            @include('forms.partials.patient')
            @include('forms.partials.visit', [
                'heading' => 'Consultation', 'from_label' => 'Examined and treated on', 'required' => !$dental,
            ])
            @include('forms.partials.items', [
                'list_id' => 'diagnosis_list', 'heading' => 'Findings and/or diagnosis', 'icon' => 'clipboard2-pulse',
                'trigger' => 'btn_add_diagnosis', 'items' => $diagnosis ?? null, 'field' => 'diagnosis',
                'edit_fn' => 'editDiagnosis', 'delete_fn' => 'deleteDiagnosis', 'required' => true,
                'empty_text' => 'No diagnosis yet. Click Add to enter one.',
            ])
        </div>
        <div class="col-lg-5">
            @include('forms.partials.physician', ['with_designation' => true, 'required' => !$dental])
            @include('forms.partials.request', ['purpose' => 'text'])
            @include('forms.partials.billing', [
                'amount_default' => isset($amount) ? number_format($amount, 2, '.', '') : null,
            ])
        </div>
    </div>
</div>
