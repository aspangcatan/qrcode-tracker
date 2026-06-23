# Medical Abstract: Chief Complaint, Diagnosis, Medication, Plan — Design

## Context

The `medical_abstract` certificate form ([resources/views/forms/medical_abstract.blade.php](../../../resources/views/forms/medical_abstract.blade.php)) currently has no fields for Chief Complaint/History of Present Illness, Diagnosis, Medication on Board, or Plan. The printed PDF ([resources/views/pdf/medical_abstract.blade.php](../../../resources/views/pdf/medical_abstract.blade.php)) renders those 4 sections as blank lines for the attending physician to handwrite on the printed paper.

The app already has an identical pattern for "Diagnosis" used by other certificate types (coc, ordinary, medico_legal, aksyon_agad, maipp): a `diagnosis` table (`id`, `certificate_id`, `diagnosis` text), a `DiagnosisService`, and an "ADD DIAGNOSIS" modal that builds a repeatable add/edit/delete list, submitted as an array and looped over when rendering the PDF. `medical_abstract` is already routed through this machinery in `storeCertificate()` (it calls `handleDiagnosis`/`handleSustained` unconditionally) — it's just never been wired into this form's UI.

Three new tables — `chief_complaints` (`id`, `certificate_id`, `chief_complaint`), `medications` (`id`, `certificate_id`, `medication`), `plans` (`id`, `certificate_id`, `plan`) — have already been created directly in the `qr_tracker` database by the user. No Laravel migrations will be written for them; the schema is managed directly in the DB for this project.

## Goal

Make the `medical_abstract` certificate creation/edit form collect Chief Complaint, Diagnosis, Medication on Board, and Plan as repeatable lists (matching the existing Diagnosis UX), persist them via the new tables, and render the saved entries on the printed PDF in place of the current blank lines.

## Decisions

- **List behavior**: all 4 fields are repeatable add/edit/delete lists (multiple entries per certificate), not single textareas — matching the shape of the new tables (one row per entry) and the existing Diagnosis UX.
- **Diagnosis reuse**: Diagnosis is wired into `medical_abstract` by reusing the *existing* `diagnosis` table/service/modal/JS completely unchanged — no new table or duplicate code for it.
- **PDF rendering**: the PDF prints the actual saved entries (dynamic loop, one line per item) instead of blank handwriting lines. Sections with zero saved entries print with no lines — no reserved blank space.
- **Validation**: none of the 4 fields become required. This matches today's behavior, where Diagnosis is already optional for `medical_abstract`/`coc`/`common` (see the `type != "medical_abstract" && ...` exclusion in `js/home.blade.php`).
- **Migrations**: not used for this feature. The 3 new tables are managed directly in the DB; no Laravel migration files will be created.
- **Code generalization (Approach C)**: only the 3 *new* fields (Chief Complaint, Medication, Plan) share one generic modal + JS helper. The existing Diagnosis modal/JS/service is left completely untouched, since it's proven working code used by multiple other certificate types — it's reused as-is, just plugged into this form by adding the missing `#diagnosis_list` table. On the backend, each new field still gets its own small dedicated Service class (not a generic one), matching the existing convention where `DiagnosisService` and `SustainedService` are separate near-identical classes rather than a shared abstraction.

## Backend

### New Service classes

`app/Services/ChiefComplaintService.php`, `app/Services/MedicationService.php`, `app/Services/PlanService.php` — each mirrors [app/Services/DiagnosisService.php](../../../app/Services/DiagnosisService.php) exactly:

```php
class ChiefComplaintService
{
    public function getByCertificate($certificate_id)
    {
        return DB::table('qr_tracker.chief_complaints')
            ->where('certificate_id', '=', $certificate_id)
            ->get();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.chief_complaints')->insert($data);
    }

    public function delete($certificate_id)
    {
        DB::table('qr_tracker.chief_complaints')
            ->where('certificate_id', '=', $certificate_id)
            ->delete();
    }
}
```

`MedicationService` and `PlanService` are the same shape against `medications`/`medication` and `plans`/`plan` respectively.

### `ApplicationController.php` changes

- Constructor: inject `ChiefComplaintService`, `MedicationService`, `PlanService` (alongside the existing `diagnosisService`, `sustainedService`).
- Add private handler methods mirroring `handleDiagnosis`/`handleSustained` (~line 768 onward): `handleChiefComplaint($items, $certificate_id)`, `handleMedication($items, $certificate_id)`, `handlePlan($items, $certificate_id)` — each deletes existing rows for the certificate, then re-inserts the submitted array.
- `storeCertificate()` (~line 205): call the 3 new handlers alongside the existing `handleDiagnosis`/`handleSustained` calls, in both the looped-documents branch and the single-certificate branch.
- `partialForm()` (~line 362, `medical_abstract` case at ~line 435): when `$request->has('id')` (edit mode), fetch `diagnosis` (already computed at the top of the method but currently dropped for this type) plus the 3 new lists, and add them to the `compact(...)` call passed to `forms.medical_abstract`.
- `printPreview()` (~line 450, `medical_abstract` case at ~line 619): fetch the 3 new lists (diagnosis is already fetched unconditionally at the top of the method) and add them to the array passed to `pdf.medical_abstract`.
- `showCertificate()` (~line 186): add the 3 new lists to the JSON response, same as `diagnosis`/`sustained` are today.

## Frontend

### `resources/views/forms/medical_abstract.blade.php`

Add 4 sections (placed to match the printed layout — Chief Complaint, Diagnosis, Medication on Board, Plan), each rendering a list table populated server-side in edit mode, following the exact markup pattern of `#diagnosis_list` in [resources/views/forms/coc.blade.php](../../../resources/views/forms/coc.blade.php) (lines 95-113):

```blade
<table id="chief_complaint_list" class="w-50">
    @if(isset($chief_complaints) && $chief_complaints)
        @foreach($chief_complaints as $item)
            <tr>
                <td style='width: 90%'>{!! $item->chief_complaint !!}</td>
                <td style='width: 5%'><button type="button" class='btn btn-sm btn-transparent' onClick="editListItem(this)"><i class='bi bi-pencil-fill text-success'></i></button></td>
                <td style='width: 5%'><button type="button" class='btn btn-sm btn-transparent' onClick="deleteListItem(this)"><i class='bi bi-trash-fill text-danger'></i></button></td>
            </tr>
        @endforeach
    @endif
</table>
```

Same shape for `#diagnosis_list` (reusing existing `$diagnosis`/`diagnosis` field, existing `editDiagnosis`/`deleteDiagnosis` handlers — unchanged from how `coc.blade.php` already does it), `#medication_list`, and `#plan_list`.

### `resources/views/modals/certificate.blade.php`

- No changes for Diagnosis — its modal and "ADD DIAGNOSIS" button already exist and are already shown for every certificate type's modal footer.
- Add one new generic modal, e.g. `#list_item_modal`, with a dynamic title/label (set via JS before showing), reused for Chief Complaint, Medication, and Plan.
- Add 3 new footer buttons: "ADD CHIEF COMPLAINT", "ADD MEDICATION", "ADD PLAN".

### `resources/views/js/home.blade.php`

- A small config map, e.g.:
  ```js
  const LIST_FIELDS = {
      chief_complaint: { listId: 'chief_complaint_list', label: 'Enter chief complaint / history of present illness' },
      medication: { listId: 'medication_list', label: 'Enter medication' },
      plan: { listId: 'plan_list', label: 'Enter plan' },
  };
  ```
- Generic functions `openListModal(key)`, `saveListItem()`, `editListItem(button)`, `deleteListItem(button)` replicate the exact behavior of `btn_add_diagnosis` / `btn_save_diagnosis` / `editDiagnosis` / `deleteDiagnosis`, parameterized by the current field key instead of being hardcoded to `#diagnosis`.
- In the partial-form-load success handler (~line 213, where `.modal-footer` is unhidden after loading a certificate type's form), show the 3 new buttons only when `type === 'medical_abstract'`; hide them otherwise.
- In `btn_save`'s submit handler (~line 407 onward), alongside the existing `diagnosis_array` building loop (~line 448-455), add equivalent loops for `chief_complaints`, `medications`, `plans`, and include all three in the JSON payload sent to `storeCertificate`.

### `resources/views/pdf/medical_abstract.blade.php`

Replace each section's fixed blank `<tr>` rows (lines 266-361: Chief Complaint at 267-291, Diagnosis at 292-311, Medication on Board at 312-336, Plan at 337-361) with a dynamic loop over the corresponding array, matching the loop style already used for diagnosis in [resources/views/pdf/coc.blade.php](../../../resources/views/pdf/coc.blade.php) (lines 274-278):

```blade
<table style="width: 100%; margin-top: 20px">
    <tr>
        <td style="width: 45%">Chief Complaint/History of Present Illness:</td>
        <td><div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : (isset($chief_complaints[0]) ? $chief_complaints[0]->chief_complaint : '') }}</div></td>
    </tr>
    @for($i = 1; $i < count($chief_complaints); $i++)
        <tr>
            <td colspan="2"><div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $chief_complaints[$i]->chief_complaint }}</div></td>
        </tr>
    @endfor
</table>
```

Same shape for Diagnosis, Medication on Board, and Plan. Sections with zero entries print the heading with an empty line and no extra rows — no reserved blank handwriting space.

## Out of scope

- No required-field validation for any of the 4 fields.
- No changes to any certificate type other than `medical_abstract`.
- No changes to the existing Diagnosis modal/JS/service code path.
- No Laravel migrations for the 3 new tables.
