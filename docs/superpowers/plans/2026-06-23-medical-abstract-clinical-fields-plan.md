# Medical Abstract Clinical Fields Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add Chief Complaint, Diagnosis, Medication on Board, and Plan as repeatable add/edit/delete lists to the `medical_abstract` certificate form, persist them via dedicated tables, and render the saved entries on the printed PDF.

**Architecture:** Three new Service classes (`ChiefComplaintService`, `MedicationService`, `PlanService`) mirror the existing `DiagnosisService` exactly. The existing Diagnosis modal/list/JS is reused unchanged for this form (it just gets the missing `#diagnosis_list` table). Chief Complaint, Medication, and Plan share one new generic modal and a small set of parameterized JS functions, since they're new and have no existing code to risk. No automated tests are added — this repo has none for comparable features (`DiagnosisService`/`SustainedService` are untested), and per project decision, verification here is manual via the browser, matching existing convention.

**Tech Stack:** Laravel 8, Blade, jQuery, MySQL (`qr_tracker` connection; tables already created directly in the DB — no migrations in this plan).

**Spec:** [docs/superpowers/specs/2026-06-23-medical-abstract-clinical-fields-design.md](../specs/2026-06-23-medical-abstract-clinical-fields-design.md)

---

### Task 1: Create ChiefComplaintService

**Files:**
- Create: `app/Services/ChiefComplaintService.php`

- [ ] **Step 1: Write the service**

```php
<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

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

- [ ] **Step 2: Lint check**

Run: `php -l app/Services/ChiefComplaintService.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Manually verify against the real table via tinker**

Run: `php artisan tinker`
```
>>> app(\App\Services\ChiefComplaintService::class)->store([['certificate_id' => 999999, 'chief_complaint' => 'test entry']]);
>>> app(\App\Services\ChiefComplaintService::class)->getByCertificate(999999);
>>> app(\App\Services\ChiefComplaintService::class)->delete(999999);
>>> app(\App\Services\ChiefComplaintService::class)->getByCertificate(999999);
```
Expected: the `store` call returns `true`, `getByCertificate` returns a collection with one row (`chief_complaint` = `"test entry"`), and after `delete`, `getByCertificate` returns an empty collection. (Uses a throwaway `certificate_id` of `999999` so no real data is touched.)

- [ ] **Step 4: Commit**

```bash
git add app/Services/ChiefComplaintService.php
git commit -m "Add ChiefComplaintService"
```

---

### Task 2: Create MedicationService

**Files:**
- Create: `app/Services/MedicationService.php`

- [ ] **Step 1: Write the service**

```php
<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class MedicationService
{

    public function getByCertificate($certificate_id)
    {
        return DB::table('qr_tracker.medications')
            ->where('certificate_id', '=', $certificate_id)
            ->get();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.medications')->insert($data);
    }

    public function delete($certificate_id)
    {
        DB::table('qr_tracker.medications')
            ->where('certificate_id', '=', $certificate_id)
            ->delete();
    }
}
```

- [ ] **Step 2: Lint check**

Run: `php -l app/Services/MedicationService.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Manually verify against the real table via tinker**

Run: `php artisan tinker`
```
>>> app(\App\Services\MedicationService::class)->store([['certificate_id' => 999999, 'medication' => 'test entry']]);
>>> app(\App\Services\MedicationService::class)->getByCertificate(999999);
>>> app(\App\Services\MedicationService::class)->delete(999999);
>>> app(\App\Services\MedicationService::class)->getByCertificate(999999);
```
Expected: same as Task 1 Step 3 — insert succeeds, one row comes back, then an empty collection after delete.

- [ ] **Step 4: Commit**

```bash
git add app/Services/MedicationService.php
git commit -m "Add MedicationService"
```

---

### Task 3: Create PlanService

**Files:**
- Create: `app/Services/PlanService.php`

- [ ] **Step 1: Write the service**

```php
<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class PlanService
{

    public function getByCertificate($certificate_id)
    {
        return DB::table('qr_tracker.plans')
            ->where('certificate_id', '=', $certificate_id)
            ->get();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.plans')->insert($data);
    }

    public function delete($certificate_id)
    {
        DB::table('qr_tracker.plans')
            ->where('certificate_id', '=', $certificate_id)
            ->delete();
    }
}
```

- [ ] **Step 2: Lint check**

Run: `php -l app/Services/PlanService.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Manually verify against the real table via tinker**

Run: `php artisan tinker`
```
>>> app(\App\Services\PlanService::class)->store([['certificate_id' => 999999, 'plan' => 'test entry']]);
>>> app(\App\Services\PlanService::class)->getByCertificate(999999);
>>> app(\App\Services\PlanService::class)->delete(999999);
>>> app(\App\Services\PlanService::class)->getByCertificate(999999);
```
Expected: same as Task 1 Step 3.

- [ ] **Step 4: Commit**

```bash
git add app/Services/PlanService.php
git commit -m "Add PlanService"
```

---

### Task 4: Inject new services into ApplicationController and add handler methods

**Files:**
- Modify: `app/Http/Controllers/ApplicationController.php:5-38` (imports, properties, constructor)
- Modify: `app/Http/Controllers/ApplicationController.php:767-803` (after `handleSustained`)

- [ ] **Step 1: Add imports**

In `app/Http/Controllers/ApplicationController.php`, after the existing `use App\Services\DiagnosisService;` line (line 9), add:

```php
use App\Services\ChiefComplaintService;
use App\Services\MedicationService;
use App\Services\PlanService;
```

- [ ] **Step 2: Add properties and constructor injection**

Replace:

```php
class ApplicationController extends Controller
{
    protected $certificateService, $diagnosisService, $sustainedService, $homisService, $queueService;

    public function __construct(
        CertificateService $certificateService,
        DiagnosisService $diagnosisService,
        SustainedService $sustainedService,
        HomisServices $homisService,
        QueueService $queueService
    ) {
        $this->certificateService = $certificateService;
        $this->diagnosisService = $diagnosisService;
        $this->sustainedService = $sustainedService;
        $this->homisService = $homisService;
        $this->queueService = $queueService;
    }
```

with:

```php
class ApplicationController extends Controller
{
    protected $certificateService, $diagnosisService, $sustainedService, $homisService, $queueService, $chiefComplaintService, $medicationService, $planService;

    public function __construct(
        CertificateService $certificateService,
        DiagnosisService $diagnosisService,
        SustainedService $sustainedService,
        HomisServices $homisService,
        QueueService $queueService,
        ChiefComplaintService $chiefComplaintService,
        MedicationService $medicationService,
        PlanService $planService
    ) {
        $this->certificateService = $certificateService;
        $this->diagnosisService = $diagnosisService;
        $this->sustainedService = $sustainedService;
        $this->homisService = $homisService;
        $this->queueService = $queueService;
        $this->chiefComplaintService = $chiefComplaintService;
        $this->medicationService = $medicationService;
        $this->planService = $planService;
    }
```

- [ ] **Step 3: Add handler methods**

After the existing `handleSustained` method (ends at line 803 with its closing `}`), add:

```php
    /**
     * Handle chief complaint data.
     *
     * @param array $chief_complaints
     * @param int $certificate_id
     * @return void
     */
    private function handleChiefComplaint($chief_complaints, $certificate_id)
    {
        if ($chief_complaints) {
            $params = [];
            foreach ($chief_complaints as $item) {
                $params[] = [
                    'certificate_id' => $certificate_id,
                    'chief_complaint' => $item['chief_complaint']
                ];
            }
            $this->chiefComplaintService->delete($certificate_id);
            $this->chiefComplaintService->store($params);
        }
    }

    /**
     * Handle medication data.
     *
     * @param array $medications
     * @param int $certificate_id
     * @return void
     */
    private function handleMedication($medications, $certificate_id)
    {
        if ($medications) {
            $params = [];
            foreach ($medications as $item) {
                $params[] = [
                    'certificate_id' => $certificate_id,
                    'medication' => $item['medication']
                ];
            }
            $this->medicationService->delete($certificate_id);
            $this->medicationService->store($params);
        }
    }

    /**
     * Handle plan data.
     *
     * @param array $plans
     * @param int $certificate_id
     * @return void
     */
    private function handlePlan($plans, $certificate_id)
    {
        if ($plans) {
            $params = [];
            foreach ($plans as $item) {
                $params[] = [
                    'certificate_id' => $certificate_id,
                    'plan' => $item['plan']
                ];
            }
            $this->planService->delete($certificate_id);
            $this->planService->store($params);
        }
    }
```

- [ ] **Step 4: Lint check**

Run: `php -l app/Http/Controllers/ApplicationController.php`
Expected: `No syntax errors detected`

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/ApplicationController.php
git commit -m "Wire ChiefComplaint/Medication/Plan services into ApplicationController"
```

---

### Task 5: Call new handlers from storeCertificate()

**Files:**
- Modify: `app/Http/Controllers/ApplicationController.php:205-230` (`storeCertificate`)

- [ ] **Step 1: Add the 3 new handler calls in both branches**

Replace:

```php
            for ($i = 0; $i < $request->no_copies; $i++) {
                if (!in_array($type, $excluded_certificate)) {
                    foreach ($specific_documents as $document_type) {
                        $certificate_id = $this->createCertificate($request, $document_type);
                        $this->handleDiagnosis($request->diagnosis, $certificate_id);
                        $this->handleSustained($request->sustained, $certificate_id);
                    }
                } else {
                    $certificate_id = $this->createCertificate($request, '');
                    $this->handleDiagnosis($request->diagnosis, $certificate_id);
                    $this->handleSustained($request->sustained, $certificate_id);
                }
            }
```

with:

```php
            for ($i = 0; $i < $request->no_copies; $i++) {
                if (!in_array($type, $excluded_certificate)) {
                    foreach ($specific_documents as $document_type) {
                        $certificate_id = $this->createCertificate($request, $document_type);
                        $this->handleDiagnosis($request->diagnosis, $certificate_id);
                        $this->handleSustained($request->sustained, $certificate_id);
                        $this->handleChiefComplaint($request->chief_complaints, $certificate_id);
                        $this->handleMedication($request->medications, $certificate_id);
                        $this->handlePlan($request->plans, $certificate_id);
                    }
                } else {
                    $certificate_id = $this->createCertificate($request, '');
                    $this->handleDiagnosis($request->diagnosis, $certificate_id);
                    $this->handleSustained($request->sustained, $certificate_id);
                    $this->handleChiefComplaint($request->chief_complaints, $certificate_id);
                    $this->handleMedication($request->medications, $certificate_id);
                    $this->handlePlan($request->plans, $certificate_id);
                }
            }
```

- [ ] **Step 2: Lint check**

Run: `php -l app/Http/Controllers/ApplicationController.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/ApplicationController.php
git commit -m "Persist chief complaint/medication/plan on certificate save"
```

---

### Task 6: Load the 3 new lists (plus diagnosis) in partialForm() edit mode

**Files:**
- Modify: `app/Http/Controllers/ApplicationController.php:435-439` (`medical_abstract` case inside `partialForm`)

- [ ] **Step 1: Update the medical_abstract case**

Replace:

```php
            case "medical_abstract":
                if ($request->has('id')) {
                    return view('forms.medical_abstract', compact('certificates', 'receivers'));
                }
                return view('forms.medical_abstract', compact('certificate_no', 'receivers', 'amount'));
```

with:

```php
            case "medical_abstract":
                if ($request->has('id')) {
                    $chief_complaints = $this->chiefComplaintService->getByCertificate($request->id);
                    $medications = $this->medicationService->getByCertificate($request->id);
                    $plans = $this->planService->getByCertificate($request->id);
                    return view('forms.medical_abstract', compact('certificates', 'diagnosis', 'chief_complaints', 'medications', 'plans', 'receivers'));
                }
                return view('forms.medical_abstract', compact('certificate_no', 'receivers', 'amount'));
```

(`$diagnosis` is already computed unconditionally at the top of `partialForm()` at line 370 — it was simply never passed into this view before.)

- [ ] **Step 2: Lint check**

Run: `php -l app/Http/Controllers/ApplicationController.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/ApplicationController.php
git commit -m "Load chief complaint/diagnosis/medication/plan lists when editing a medical_abstract certificate"
```

---

### Task 7: Load the 3 new lists in printPreview() for the PDF

**Files:**
- Modify: `app/Http/Controllers/ApplicationController.php:619-631` (`medical_abstract` case inside `printPreview`)

- [ ] **Step 1: Update the medical_abstract case**

Replace:

```php
                case "medical_abstract":
                    return view(
                        'pdf.medical_abstract',
                        [
                            'certificate' => $certificate,
                            'hide_details' => filter_var($request->hide_details, FILTER_VALIDATE_BOOLEAN),
                            'd_margin_top' => $request->d_margin_top,
                            'd_margin_bottom' => $request->d_margin_bottom,
                            's_margin_top' => $request->s_margin_top,
                            's_margin_bottom' => $request->s_margin_bottom,
                            'seal_margin_top' => $request->seal_margin_top
                        ]
                    );
```

with:

```php
                case "medical_abstract":
                    $chief_complaints = $this->chiefComplaintService->getByCertificate($request->id);
                    $medications = $this->medicationService->getByCertificate($request->id);
                    $plans = $this->planService->getByCertificate($request->id);
                    return view(
                        'pdf.medical_abstract',
                        [
                            'certificate' => $certificate,
                            'diagnosis' => $diagnosis,
                            'chief_complaints' => $chief_complaints,
                            'medications' => $medications,
                            'plans' => $plans,
                            'hide_details' => filter_var($request->hide_details, FILTER_VALIDATE_BOOLEAN),
                            'd_margin_top' => $request->d_margin_top,
                            'd_margin_bottom' => $request->d_margin_bottom,
                            's_margin_top' => $request->s_margin_top,
                            's_margin_bottom' => $request->s_margin_bottom,
                            'seal_margin_top' => $request->seal_margin_top
                        ]
                    );
```

(`$diagnosis` is already fetched unconditionally near the top of `printPreview()` at line 458, for every certificate type.)

- [ ] **Step 2: Lint check**

Run: `php -l app/Http/Controllers/ApplicationController.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/ApplicationController.php
git commit -m "Pass chief complaint/diagnosis/medication/plan lists to medical_abstract PDF view"
```

---

### Task 8: Add the 3 new lists to showCertificate()'s JSON response

**Files:**
- Modify: `app/Http/Controllers/ApplicationController.php:186-202` (`showCertificate`)

- [ ] **Step 1: Update the response payload**

Replace:

```php
            return response()->json([
                'data' => $certificateData,
                'diagnosis' => $this->diagnosisService->getDiagnosisByCertificate($certificate),
                'sustained' => $this->sustainedService->getSustainedByCertificate($certificate),
            ]);
```

with:

```php
            return response()->json([
                'data' => $certificateData,
                'diagnosis' => $this->diagnosisService->getDiagnosisByCertificate($certificate),
                'sustained' => $this->sustainedService->getSustainedByCertificate($certificate),
                'chief_complaints' => $this->chiefComplaintService->getByCertificate($certificate),
                'medications' => $this->medicationService->getByCertificate($certificate),
                'plans' => $this->planService->getByCertificate($certificate),
            ]);
```

- [ ] **Step 2: Lint check**

Run: `php -l app/Http/Controllers/ApplicationController.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/ApplicationController.php
git commit -m "Include chief complaint/medication/plan lists in showCertificate response"
```

---

### Task 9: Add the 4 list sections to the medical_abstract form

**Files:**
- Modify: `resources/views/forms/medical_abstract.blade.php:144-147` (between the patient details table and the doctor container)

- [ ] **Step 1: Insert the 4 list sections**

In `resources/views/forms/medical_abstract.blade.php`, the patient-details table closes at line 145-146 (`</table>` / `</div>`), immediately followed by `<div class="doctor-container mt-3 d-none">` at line 147. Insert the following block between them:

```blade
    <div class="d-flex flex-column mt-3 mb-3">
        <label>Chief Complaint/History of Present Illness:</label>
        <table id="chief_complaint_list" class="w-75">
            @if(isset($chief_complaints) && $chief_complaints)
                @foreach($chief_complaints as $item)
                    <tr>
                        <td style='width: 90%'>{!! $item->chief_complaint !!}</td>
                        <td style='width: 5%'>
                            <button type="button" class='btn btn-sm btn-transparent' onClick='editListItem(this)'><i
                                    class='bi bi-pencil-fill text-success'></i></button>
                        </td>
                        <td style='width: 5%'>
                            <button type="button" class='btn btn-sm btn-transparent' onClick='deleteListItem(this)'><i
                                    class='bi bi-trash-fill text-danger'></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>

        <label class="mt-2">Diagnosis:</label>
        <table id="diagnosis_list" class="w-75">
            @if(isset($diagnosis) && $diagnosis)
                @foreach($diagnosis as $item)
                    <tr>
                        <td style='width: 90%'>{!! $item->diagnosis !!}</td>
                        <td style='width: 5%'>
                            <button type="button" class='btn btn-sm btn-transparent' onClick='editDiagnosis(this)'><i
                                    class='bi bi-pencil-fill text-success'></i></button>
                        </td>
                        <td style='width: 5%'>
                            <button type="button" class='btn btn-sm btn-transparent' onClick='deleteDiagnosis(this)'><i
                                    class='bi bi-trash-fill text-danger'></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>

        <label class="mt-2">Medication on Board:</label>
        <table id="medication_list" class="w-75">
            @if(isset($medications) && $medications)
                @foreach($medications as $item)
                    <tr>
                        <td style='width: 90%'>{!! $item->medication !!}</td>
                        <td style='width: 5%'>
                            <button type="button" class='btn btn-sm btn-transparent' onClick='editListItem(this)'><i
                                    class='bi bi-pencil-fill text-success'></i></button>
                        </td>
                        <td style='width: 5%'>
                            <button type="button" class='btn btn-sm btn-transparent' onClick='deleteListItem(this)'><i
                                    class='bi bi-trash-fill text-danger'></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>

        <label class="mt-2">Plan:</label>
        <table id="plan_list" class="w-75">
            @if(isset($plans) && $plans)
                @foreach($plans as $item)
                    <tr>
                        <td style='width: 90%'>{!! $item->plan !!}</td>
                        <td style='width: 5%'>
                            <button type="button" class='btn btn-sm btn-transparent' onClick='editListItem(this)'><i
                                    class='bi bi-pencil-fill text-success'></i></button>
                        </td>
                        <td style='width: 5%'>
                            <button type="button" class='btn btn-sm btn-transparent' onClick='deleteListItem(this)'><i
                                    class='bi bi-trash-fill text-danger'></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/forms/medical_abstract.blade.php
git commit -m "Add chief complaint/diagnosis/medication/plan list sections to medical_abstract form"
```

---

### Task 10: Add the generic list-item modal and 3 new buttons

**Files:**
- Modify: `resources/views/modals/certificate.blade.php:1-40`

- [ ] **Step 1: Add 3 new footer buttons**

Replace:

```blade
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
                <button class="btn btn-primary ml-1 mr-1" id="btn_add_doctor">ADD PHYSICIAN</button>
                <button class="btn btn-warning ml-1 mr-1" id="btn_add_diagnosis">ADD DIAGNOSIS</button>
                <button class="btn btn-success ml-1" id="btn_save">SAVE</button>
            </div>
```

with:

```blade
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
                <button class="btn btn-primary ml-1 mr-1" id="btn_add_doctor">ADD PHYSICIAN</button>
                <button class="btn btn-warning ml-1 mr-1" id="btn_add_diagnosis">ADD DIAGNOSIS</button>
                <button class="btn btn-warning ml-1 mr-1 list-field-btn d-none" id="btn_add_chief_complaint" data-field="chief_complaint">ADD CHIEF COMPLAINT</button>
                <button class="btn btn-warning ml-1 mr-1 list-field-btn d-none" id="btn_add_medication" data-field="medication">ADD MEDICATION</button>
                <button class="btn btn-warning ml-1 mr-1 list-field-btn d-none" id="btn_add_plan" data-field="plan">ADD PLAN</button>
                <button class="btn btn-success ml-1" id="btn_save">SAVE</button>
            </div>
```

(Buttons start hidden via `d-none`; Task 13 makes them visible only for `medical_abstract`.)

- [ ] **Step 2: Add the generic modal**

Immediately after the existing `diagnosis_modal` block (ends at line 40 with `</div>`), add:

```blade
<div class="modal fade" id="list_item_modal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-title p-1" style="font-size: 24px" id="list_item_modal_title">Enter item</div>
            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <textarea type="text" class="form-control" id="list_item_input" style="height: 300px"></textarea>
                    <label>Enter here</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary mr-1" data-bs-dismiss="modal">CANCEL</button>
                <button class="btn btn-success ml-1" id="btn_save_list_item">SAVE</button>
            </div>
        </div>
    </div>
</div>
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/modals/certificate.blade.php
git commit -m "Add generic list-item modal and buttons for chief complaint/medication/plan"
```

---

### Task 11: Add JS state, config, and the modal-open handler

**Files:**
- Modify: `resources/views/js/home.blade.php:1-12` (top-level state)
- Modify: `resources/views/js/home.blade.php:336-340` (near `btn_add_diagnosis` handler)

- [ ] **Step 1: Add state variables and field config**

Replace:

```js
    let DOCTORS = [];
    let page = 0;
    let certificate_id = 0;
    let diagnosis_index = -1;
```

with:

```js
    let DOCTORS = [];
    let page = 0;
    let certificate_id = 0;
    let diagnosis_index = -1;
    let list_item_index = -1;
    let current_list_field = '';
    const LIST_FIELDS = {
        chief_complaint: {listId: 'chief_complaint_list', label: 'Enter chief complaint / history of present illness'},
        medication: {listId: 'medication_list', label: 'Enter medication'},
        plan: {listId: 'plan_list', label: 'Enter plan'}
    };
```

- [ ] **Step 2: Add the click handler that opens the modal**

After the existing handler:

```js
        $("#btn_add_diagnosis").click(function () {
            diagnosis_index = -1;
            $("#diagnosis").val("");
            $("#diagnosis_modal").modal("show");
        });
```

add:

```js
        $(".list-field-btn").click(function () {
            current_list_field = $(this).data("field");
            list_item_index = -1;
            $("#list_item_input").val("");
            $("#list_item_modal_title").text(LIST_FIELDS[current_list_field].label);
            $("#list_item_modal").modal("show");
        });
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/js/home.blade.php
git commit -m "Add JS state/config and modal-open handler for chief complaint/medication/plan"
```

---

### Task 12: Add the generic save/edit/delete JS functions

**Files:**
- Modify: `resources/views/js/home.blade.php:368-390` (near `btn_save_diagnosis` handler)
- Modify: `resources/views/js/home.blade.php:860-875` (near `editDiagnosis`/`deleteDiagnosis`)

- [ ] **Step 1: Add the generic save handler**

After the existing handler:

```js
        $("#btn_save_diagnosis").click(function () {
            let diagnosis = $("#diagnosis").val();
            diagnosis = diagnosis.replace(/\n/g, "");

            if (diagnosis == '') {
                alert("Please fill in diagnosis");
                return;
            }

            if (diagnosis_index > -1) {
                $("#diagnosis_list tr:eq(" + diagnosis_index + ") td:eq(0)").html(diagnosis);
                $("#diagnosis_modal").modal("hide");
                diagnosis_index = -1;
            } else {
                let tr = "<tr>";
                tr += "<td style='width: 90%'>" + diagnosis + "</td>"
                tr += "<td style='width: 5%'><button type='button' class='btn btn-sm btn-transparent' onClick='editDiagnosis(this)'><i class='bi bi-pencil-fill text-success'></i></button></td>"
                tr += "<td style='width: 5%'><button type='button' class='btn btn-sm btn-transparent' onClick='deleteDiagnosis(this)'><i class='bi bi-trash-fill text-danger'></i></button></td>"
                tr += "</tr>";
                $("#diagnosis_list").append(tr);
            }
            $("#diagnosis").val("");
        });
```

add:

```js
        $("#btn_save_list_item").click(function () {
            let value = $("#list_item_input").val();
            value = value.replace(/\n/g, "");

            if (value == '') {
                alert("Please fill in this field");
                return;
            }

            const listId = LIST_FIELDS[current_list_field].listId;
            if (list_item_index > -1) {
                $("#" + listId + " tr:eq(" + list_item_index + ") td:eq(0)").html(value);
                $("#list_item_modal").modal("hide");
                list_item_index = -1;
            } else {
                let tr = "<tr>";
                tr += "<td style='width: 90%'>" + value + "</td>"
                tr += "<td style='width: 5%'><button type='button' class='btn btn-sm btn-transparent' onClick='editListItem(this)'><i class='bi bi-pencil-fill text-success'></i></button></td>"
                tr += "<td style='width: 5%'><button type='button' class='btn btn-sm btn-transparent' onClick='deleteListItem(this)'><i class='bi bi-trash-fill text-danger'></i></button></td>"
                tr += "</tr>";
                $("#" + listId).append(tr);
            }
            $("#list_item_input").val("");
        });
```

- [ ] **Step 2: Add the generic edit/delete functions**

After the existing functions:

```js
    function editDiagnosis(button) {
        const tr = $(button).closest('tr');
        const diagnosis = tr.find('td:first').html();
        diagnosis_index = tr.index();

        $("#diagnosis_modal").modal("show");
        const textWithLineBreaks = diagnosis.replace(/<br>/g, '<br>\n');
        $("#diagnosis").val(textWithLineBreaks);
    }

    function deleteDiagnosis(button) {
        if (confirm("Are you sure you want to remove this record?")) {
            const tr = $(button).closest('tr');
            tr.remove();
        }
    }
```

add:

```js
    function editListItem(button) {
        const tr = $(button).closest('tr');
        const table_id = tr.closest('table').attr('id');
        current_list_field = Object.keys(LIST_FIELDS).find(key => LIST_FIELDS[key].listId === table_id);
        const value = tr.find('td:first').html();
        list_item_index = tr.index();

        $("#list_item_modal_title").text(LIST_FIELDS[current_list_field].label);
        $("#list_item_modal").modal("show");
        const textWithLineBreaks = value.replace(/<br>/g, '<br>\n');
        $("#list_item_input").val(textWithLineBreaks);
    }

    function deleteListItem(button) {
        if (confirm("Are you sure you want to remove this record?")) {
            const tr = $(button).closest('tr');
            tr.remove();
        }
    }
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/js/home.blade.php
git commit -m "Add generic save/edit/delete JS functions for chief complaint/medication/plan"
```

---

### Task 13: Show the 3 new buttons only for medical_abstract

**Files:**
- Modify: `resources/views/js/home.blade.php:213-216` (create-new flow)
- Modify: `resources/views/js/home.blade.php:803-805` (edit flow, `editCertificate`)

- [ ] **Step 1: Toggle visibility in the create-new flow**

Replace:

```js
                .then(html => {
                    $("#certificate_modal #certificate_form").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");
                    $("#no_copies_container").removeClass("d-none");

                    $("#received_by").select2({
                        dropdownParent: $("#certificate_modal .modal-body"),
                        width: '100%'
                    });
                })
```

with:

```js
                .then(html => {
                    $("#certificate_modal #certificate_form").html(html);
                    $("#certificate_modal .modal-footer").removeClass("d-none");
                    $("#no_copies_container").removeClass("d-none");
                    $(".list-field-btn").toggleClass("d-none", type !== "medical_abstract");

                    $("#received_by").select2({
                        dropdownParent: $("#certificate_modal .modal-body"),
                        width: '100%'
                    });
                })
```

- [ ] **Step 2: Toggle visibility in the edit flow**

Replace:

```js
            .then(html => {
                $("#certificate_modal #certificate_form").html(html);
                $("#certificate_modal .modal-footer").removeClass("d-none");
                $("#received_by").select2({
                    dropdownParent: $("#certificate_modal .modal-body"),
                    width: '100%'
                });
            })
```

with:

```js
            .then(html => {
                $("#certificate_modal #certificate_form").html(html);
                $("#certificate_modal .modal-footer").removeClass("d-none");
                $(".list-field-btn").toggleClass("d-none", type !== "medical_abstract");
                $("#received_by").select2({
                    dropdownParent: $("#certificate_modal .modal-body"),
                    width: '100%'
                });
            })
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/js/home.blade.php
git commit -m "Show chief complaint/medication/plan buttons only for medical_abstract"
```

---

### Task 14: Include the 3 new lists in the save payload

**Files:**
- Modify: `resources/views/js/home.blade.php:448-455` (near `diagnosis_array` building)
- Modify: `resources/views/js/home.blade.php:691-728` (`params` object)

- [ ] **Step 1: Build the 3 new arrays**

After the existing block:

```js
            const diagnosis_array = [];

            for (let i = 0; i < $("#diagnosis_list tr").length; i++) {
                const diagnosis = $("#diagnosis_list tr:eq(" + i + ") td:eq(0)").html().trim();
                diagnosis_array.push({
                    diagnosis: diagnosis
                });
            }
```

add:

```js
            const chief_complaints_array = [];
            for (let i = 0; i < $("#chief_complaint_list tr").length; i++) {
                const chief_complaint = $("#chief_complaint_list tr:eq(" + i + ") td:eq(0)").html().trim();
                chief_complaints_array.push({
                    chief_complaint: chief_complaint
                });
            }

            const medications_array = [];
            for (let i = 0; i < $("#medication_list tr").length; i++) {
                const medication = $("#medication_list tr:eq(" + i + ") td:eq(0)").html().trim();
                medications_array.push({
                    medication: medication
                });
            }

            const plans_array = [];
            for (let i = 0; i < $("#plan_list tr").length; i++) {
                const plan = $("#plan_list tr:eq(" + i + ") td:eq(0)").html().trim();
                plans_array.push({
                    plan: plan
                });
            }
```

- [ ] **Step 2: Add the 3 new arrays to the submitted payload**

Replace:

```js
                "type": type,
                "diagnosis": diagnosis_array,
                "sustained": (noi === undefined) ? null : sustained,
```

with:

```js
                "type": type,
                "diagnosis": diagnosis_array,
                "chief_complaints": chief_complaints_array,
                "medications": medications_array,
                "plans": plans_array,
                "sustained": (noi === undefined) ? null : sustained,
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/js/home.blade.php
git commit -m "Submit chief complaint/medication/plan lists when saving a certificate"
```

---

### Task 15: Render the saved entries on the PDF

**Files:**
- Modify: `resources/views/pdf/medical_abstract.blade.php:266-361` (the 4 sections inside `#middle_portion`)

- [ ] **Step 1: Replace the Chief Complaint section**

Replace:

```blade
            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td style="width: 45%">
                        Chief Complaint/History of Present Illness:
                    </td>
                    <td>
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
            </table>
```

with:

```blade
            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td style="width: 45%">
                        Chief Complaint/History of Present Illness:
                    </td>
                    <td>
                        <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : (isset($chief_complaints[0]) ? $chief_complaints[0]->chief_complaint : '') }}</div>
                    </td>
                </tr>
                @for($i = 1; $i < count($chief_complaints); $i++)
                    <tr>
                        <td colspan="2">
                            <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $chief_complaints[$i]->chief_complaint }}</div>
                        </td>
                    </tr>
                @endfor
            </table>
```

- [ ] **Step 2: Replace the Diagnosis section**

Replace:

```blade
            <table style="width: 100%;margin-top: 20px">
                <tr>
                    <td style="width: 15%">
                        Diagnosis:
                    </td>
                    <td>
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
            </table>
```

with:

```blade
            <table style="width: 100%;margin-top: 20px">
                <tr>
                    <td style="width: 15%">
                        Diagnosis:
                    </td>
                    <td>
                        <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : (isset($diagnosis[0]) ? $diagnosis[0]->diagnosis : '') }}</div>
                    </td>
                </tr>
                @for($i = 1; $i < count($diagnosis); $i++)
                    <tr>
                        <td colspan="2">
                            <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $diagnosis[$i]->diagnosis }}</div>
                        </td>
                    </tr>
                @endfor
            </table>
```

- [ ] **Step 3: Replace the Medication on Board section**

Replace:

```blade
            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td style="width: 25%">
                        Medication on Board:
                    </td>
                    <td>
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
            </table>
```

with:

```blade
            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td style="width: 25%">
                        Medication on Board:
                    </td>
                    <td>
                        <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : (isset($medications[0]) ? $medications[0]->medication : '') }}</div>
                    </td>
                </tr>
                @for($i = 1; $i < count($medications); $i++)
                    <tr>
                        <td colspan="2">
                            <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $medications[$i]->medication }}</div>
                        </td>
                    </tr>
                @endfor
            </table>
```

- [ ] **Step 4: Replace the Plan section**

Replace:

```blade
            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td style="width: 15%">
                        Plan:
                    </td>
                    <td>
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
            </table>
```

with:

```blade
            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td style="width: 15%">
                        Plan:
                    </td>
                    <td>
                        <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : (isset($plans[0]) ? $plans[0]->plan : '') }}</div>
                    </td>
                </tr>
                @for($i = 1; $i < count($plans); $i++)
                    <tr>
                        <td colspan="2">
                            <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $plans[$i]->plan }}</div>
                        </td>
                    </tr>
                @endfor
            </table>
```

- [ ] **Step 5: Commit**

```bash
git add resources/views/pdf/medical_abstract.blade.php
git commit -m "Render saved chief complaint/diagnosis/medication/plan entries on medical_abstract PDF"
```

---

### Task 16: End-to-end manual verification

**Files:** none (verification only)

- [ ] **Step 1: Create a new medical_abstract certificate with all 4 list types**

In the browser: open the app, click "Add Certificate", choose Medical Abstract. Confirm the "ADD CHIEF COMPLAINT", "ADD DIAGNOSIS", "ADD MEDICATION", and "ADD PLAN" buttons all appear in the modal footer (and that no other certificate type shows the 3 new buttons — spot-check by opening, say, a COC form and confirming only "ADD DIAGNOSIS" appears).

For each of the 4 fields, click its "ADD" button, type a distinct test value (e.g. "Test chief complaint 1"), click SAVE in the small modal, and confirm a row with edit/delete icons appears in that field's list. Add a 2nd entry to at least one field to confirm multiple entries work.

Fill in the rest of the required certificate fields (Name, Age, Sex, etc.) and click the main SAVE button.

Expected: a success toast appears and the certificate list refreshes.

- [ ] **Step 2: Verify the data persisted by reopening for edit**

Click edit on the certificate just created. Confirm all 4 lists are pre-populated with the entries saved in Step 1, including the 2nd entry on whichever field got two. Edit one entry's text via its pencil icon and confirm it updates in place. Delete one entry via its trash icon and confirm the row disappears. Save again.

Expected: no console errors; success toast on save; re-opening again reflects the edit and the deletion.

- [ ] **Step 3: Verify the PDF**

Use the certificate's print/preview action. Confirm the printed PDF shows the actual saved text for Chief Complaint, Diagnosis, Medication on Board, and Plan (matching what's currently saved after Step 2's edits) instead of blank lines, and that a field with zero remaining entries (if any) prints its label with no extra blank lines underneath.

Expected: PDF renders without errors and shows the real data in all 4 sections.
