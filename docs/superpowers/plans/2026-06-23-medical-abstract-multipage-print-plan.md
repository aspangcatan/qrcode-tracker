# Medical Abstract Multi-Page Print Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let staff assign each of the medical_abstract certificate's 4 clinical sections (Chief Complaint, Diagnosis, Medication on Board, Plan) to a specific print page (1–4), with every page repeating the full header/patient-info/signature/footer and only differing in which section(s) appear in the middle.

**Architecture:** 4 new dropdowns in the shared `heading_modal` (visible only for medical_abstract), sent as query params to `printPreview()`, passed straight into the PDF view. The Blade template groups the 4 sections by assigned page (compacting any skipped page numbers), then loops over that page list, repeating the header/patient-info/signature/footer each iteration and rendering only the section(s) assigned to that page via one generic table-rendering loop. CSS `page-break-after` separates pages.

**Tech Stack:** Laravel 8, Blade, jQuery. No automated tests are added — this repo has none for comparable PDF-template logic and the prior medical_abstract feature established manual-verification-only for this codebase; this plan follows that same convention.

**Spec:** [docs/superpowers/specs/2026-06-23-medical-abstract-multipage-print-design.md](../specs/2026-06-23-medical-abstract-multipage-print-design.md)

---

### Task 1: Add page-assignment dropdowns to heading_modal

**Files:**
- Modify: `resources/views/modals/certificate.blade.php:107-124`

- [ ] **Step 1: Insert the 4 new dropdowns**

In `resources/views/modals/certificate.blade.php`, find this block inside `#heading_modal`'s body:

```blade
                <div class="form-floating mb-3 mt-2">
                    <select class="form-control" id="with_myla">
                        <option value="1" selected>Yes</option>
                        <option value="0">No</option>
                    </select>
                    <label>With Myla Assignatory</label>
                </div>
                <div class="form-floating mb-3 mt-2">
                    <select class="form-control" id="hide_middle_portion">
                        <option value="1" selected>Yes</option>
                        <option value="0">No</option>
                    </select>
                    <label>Hide details</label>
                </div>
```

Replace it with:

```blade
                <div class="form-floating mb-3 mt-2">
                    <select class="form-control" id="with_myla">
                        <option value="1" selected>Yes</option>
                        <option value="0">No</option>
                    </select>
                    <label>With Myla Assignatory</label>
                </div>
                <div class="form-floating mb-3 mt-2">
                    <select class="form-control" id="hide_middle_portion">
                        <option value="1" selected>Yes</option>
                        <option value="0">No</option>
                    </select>
                    <label>Hide details</label>
                </div>
                <div class="form-floating mb-3 mt-2 medical-abstract-only d-none">
                    <select class="form-control" id="chief_complaint_page">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                    <label>Chief Complaint Page</label>
                </div>
                <div class="form-floating mb-3 mt-2 medical-abstract-only d-none">
                    <select class="form-control" id="diagnosis_page">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                    <label>Diagnosis Page</label>
                </div>
                <div class="form-floating mb-3 mt-2 medical-abstract-only d-none">
                    <select class="form-control" id="medication_page">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                    <label>Medication on Board Page</label>
                </div>
                <div class="form-floating mb-3 mt-2 medical-abstract-only d-none">
                    <select class="form-control" id="plan_page">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                    <label>Plan Page</label>
                </div>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/modals/certificate.blade.php
git commit -m "Add per-section page-assignment dropdowns to heading_modal"
```

## Context

This is a Laravel 8 hospital certificate-tracking app. `heading_modal` is a shared print-settings popup used for every certificate type before opening the print-preview tab — it currently has margin inputs plus "With Myla Assignatory" and "Hide details" dropdowns. This task adds 4 new dropdowns (page 1–4 per clinical section), each wrapped in a `medical-abstract-only d-none` class so they start hidden — a later task makes them visible only when printing a medical_abstract certificate. This task is markup only; nothing reads or uses these new fields yet.

---

### Task 2: Toggle dropdown visibility and set defaults based on certificate type

**Files:**
- Modify: `resources/views/js/home.blade.php:859-867`

- [ ] **Step 1: Update printPreview(id)**

Find:

```js
    function printPreview(id) {
        certificate_id = id;
        $("#heading_modal").modal("show");
        //SET DEFAULTS
        $("#d_margin_top").val(50);
        $("#d_margin_bottom").val(50);
        $("#s_margin_top").val(130);
        $("#seal_margin_top").val(100);
    }
```

Replace it with:

```js
    function printPreview(id) {
        certificate_id = id;
        const print_type = $("#certificate_id_" + id + " td:eq(0)").text().trim();
        $(".medical-abstract-only").toggleClass("d-none", print_type !== "medical_abstract");
        $("#heading_modal").modal("show");
        //SET DEFAULTS
        $("#d_margin_top").val(50);
        $("#d_margin_bottom").val(50);
        $("#s_margin_top").val(130);
        $("#seal_margin_top").val(100);
        $("#chief_complaint_page").val(1);
        $("#diagnosis_page").val(1);
        $("#medication_page").val(1);
        $("#plan_page").val(1);
    }
```

(`$("#certificate_id_" + id + " td:eq(0)").text().trim()` is the same lookup `editCertificate(id)` already uses elsewhere in this file to read a certificate's type from its hidden first table column — reusing that pattern here, with a locally-scoped `print_type` variable rather than overwriting the shared global `type` variable, since `printPreview` doesn't otherwise touch `type`.)

- [ ] **Step 2: Commit**

```bash
git add resources/views/js/home.blade.php
git commit -m "Show page-assignment dropdowns only when printing a medical_abstract certificate"
```

## Context

`printPreview(id)` is called when staff click the print/QR icon on a certificate row (see `onclick="printPreview(` + it.id + `)"` elsewhere in this file) — it opens `heading_modal`. Each certificate row has a hidden `<td>` (first column) holding that row's type, the same lookup `editCertificate(id)` uses. This task makes the 4 new dropdowns from Task 1 appear only when the certificate being printed is `medical_abstract`, and resets them to page 1 every time the modal opens (mirroring how the existing margin defaults are reset).

---

### Task 3: Include page assignments in the print-preview request

**Files:**
- Modify: `resources/views/js/home.blade.php:442-455`

- [ ] **Step 1: Update btn_print_certificate's click handler**

Find:

```js
        $("#btn_print_certificate").click(function () {
            const d_margin_top = $("#d_margin_top").val();
            const d_margin_bottom = $("#d_margin_bottom").val();
            const s_margin_top = $("#s_margin_top").val();
            const seal_margin_top = $("#seal_margin_top").val();
            const with_myla = $("#with_myla").val();
            const hide_middle_portion = $("#hide_middle_portion").val();

            window.open("http://192.168.5.4/qrcode-tracker/print-preview?id=" + certificate_id +
                "&d_margin_top=" + d_margin_top +
                "&d_margin_bottom=" + d_margin_bottom + "&s_margin_top=" + s_margin_top + "&seal_margin_top=" + seal_margin_top +
                "&with_myla=" + with_myla+"&hide_details="+hide_middle_portion
                , '_blank');
        });
```

Replace it with:

```js
        $("#btn_print_certificate").click(function () {
            const d_margin_top = $("#d_margin_top").val();
            const d_margin_bottom = $("#d_margin_bottom").val();
            const s_margin_top = $("#s_margin_top").val();
            const seal_margin_top = $("#seal_margin_top").val();
            const with_myla = $("#with_myla").val();
            const hide_middle_portion = $("#hide_middle_portion").val();
            const chief_complaint_page = $("#chief_complaint_page").val();
            const diagnosis_page = $("#diagnosis_page").val();
            const medication_page = $("#medication_page").val();
            const plan_page = $("#plan_page").val();

            window.open("http://192.168.5.4/qrcode-tracker/print-preview?id=" + certificate_id +
                "&d_margin_top=" + d_margin_top +
                "&d_margin_bottom=" + d_margin_bottom + "&s_margin_top=" + s_margin_top + "&seal_margin_top=" + seal_margin_top +
                "&with_myla=" + with_myla+"&hide_details="+hide_middle_portion +
                "&chief_complaint_page=" + chief_complaint_page + "&diagnosis_page=" + diagnosis_page +
                "&medication_page=" + medication_page + "&plan_page=" + plan_page
                , '_blank');
        });
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/js/home.blade.php
git commit -m "Send per-section page assignments when opening print preview"
```

## Context

This is the same `heading_modal`'s PRINT button, shared across every certificate type — it builds the URL opened in a new tab for `ApplicationController::printPreview()`. This task appends the 4 new dropdown values as query params, the same way the existing margin/with_myla/hide_details values already are. These params are sent unconditionally for every certificate type (harmless for non-medical_abstract types, since the backend only reads them in the medical_abstract case — added in Task 4).

---

### Task 4: Pass page assignments through in the controller

**Files:**
- Modify: `app/Http/Controllers/ApplicationController.php:631-649`

- [ ] **Step 1: Update the medical_abstract case in printPreview()**

Find:

```php
                case "medical_abstract":
                    $chief_complaints = $this->chiefComplaintService->getByCertificate($request->id);
                    $medications = $this->medicationService->getByCertificate($request->id);
                    $plans = $this->planService->getByCertificate($request->id);
                    return view('pdf.medical_abstract',
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

Replace it with:

```php
                case "medical_abstract":
                    $chief_complaints = $this->chiefComplaintService->getByCertificate($request->id);
                    $medications = $this->medicationService->getByCertificate($request->id);
                    $plans = $this->planService->getByCertificate($request->id);
                    return view('pdf.medical_abstract',
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
                            'seal_margin_top' => $request->seal_margin_top,
                            'chief_complaint_page' => $request->chief_complaint_page,
                            'diagnosis_page' => $request->diagnosis_page,
                            'medication_page' => $request->medication_page,
                            'plan_page' => $request->plan_page
                        ]
                    );
```

- [ ] **Step 2: Lint check**

Run: `php -l app/Http/Controllers/ApplicationController.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/ApplicationController.php
git commit -m "Pass per-section page assignments to medical_abstract PDF view"
```

## Context

No validation or defaulting happens here — the 4 new request values are passed straight through, including when absent (`null`). The Blade template (Task 5) defaults missing/non-numeric values to page 1.

---

### Task 5: Restructure the PDF template into a multi-page loop

**Files:**
- Modify: `resources/views/pdf/medical_abstract.blade.php` (the `@php` block and the entire body inside `<div class="container" style="margin-top: 70px">`)

- [ ] **Step 1: Extend the @php block with page-grouping logic**

Find:

```blade
    @php
        $hideDetails = !empty($hide_details);

        $splitClinicalLines = function ($collection, $field) {
            $lines = [];
            foreach ($collection as $item) {
                foreach (preg_split('/<br\s*\/?>/i', $item->$field) as $segment) {
                    $segment = trim($segment);
                    if ($segment !== '') {
                        $lines[] = $segment;
                    }
                }
            }
            return $lines;
        };

        $chief_complaint_lines = $splitClinicalLines($chief_complaints, 'chief_complaint');
        $diagnosis_lines = $splitClinicalLines($diagnosis, 'diagnosis');
        $medication_lines = $splitClinicalLines($medications, 'medication');
        $plan_lines = $splitClinicalLines($plans, 'plan');
    @endphp
```

Replace it with:

```blade
    @php
        $hideDetails = !empty($hide_details);

        $splitClinicalLines = function ($collection, $field) {
            $lines = [];
            foreach ($collection as $item) {
                foreach (preg_split('/<br\s*\/?>/i', $item->$field) as $segment) {
                    $segment = trim($segment);
                    if ($segment !== '') {
                        $lines[] = $segment;
                    }
                }
            }
            return $lines;
        };

        $chief_complaint_lines = $splitClinicalLines($chief_complaints, 'chief_complaint');
        $diagnosis_lines = $splitClinicalLines($diagnosis, 'diagnosis');
        $medication_lines = $splitClinicalLines($medications, 'medication');
        $plan_lines = $splitClinicalLines($plans, 'plan');

        $sectionDefs = [
            'chief_complaint' => ['label' => 'Chief Complaint/History of Present Illness:', 'width' => 45, 'lines' => $chief_complaint_lines, 'page' => max(1, (int) ($chief_complaint_page ?? 1))],
            'diagnosis' => ['label' => 'Diagnosis:', 'width' => 15, 'lines' => $diagnosis_lines, 'page' => max(1, (int) ($diagnosis_page ?? 1))],
            'medication' => ['label' => 'Medication on Board:', 'width' => 25, 'lines' => $medication_lines, 'page' => max(1, (int) ($medication_page ?? 1))],
            'plan' => ['label' => 'Plan:', 'width' => 15, 'lines' => $plan_lines, 'page' => max(1, (int) ($plan_page ?? 1))],
        ];

        $pages = collect($sectionDefs)
            ->pluck('page')
            ->unique()
            ->sort()
            ->values()
            ->map(fn($pageNum) => array_filter($sectionDefs, fn($s) => $s['page'] === $pageNum))
            ->values();
    @endphp
```

- [ ] **Step 2: Replace the entire body with the page-looped version**

Find this entire block (from the opening `<div class="container"...>` through its matching closing `</div>`, immediately before the `<script>` tag):

```blade
    <div class="container" style="margin-top: 70px">
        <table style="width: 100%">
            <tr>
                <td rowspan="3">
                    <div style="height: 100%;vertical-align: middle;text-align: center">
                        {!! QrCode::size(100)->generate($certificate->url) !!}
                    </div>
                </td>
                <td>
                    <div style="text-align: right">
                        Certificate No:
                        <div class="small fw-bold">{{ $hideDetails ? '' : $certificate->certificate_no }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="text-align: right">
                        Hospital No:
                        <div class="small fw-bold">{{ $hideDetails ? '' : $certificate->health_record_no }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="text-align: right">
                        Date:
                        <div class="small fw-bold">
                            {{ $hideDetails ? '' : strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_issued)->format('F j, Y')) }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="{{ $hideDetails ? 'preserve-empty-space' : '' }}">
            <div class="certificate-title">
                MEDICAL ABSTRACT
            </div>
            <table style="width: 100%">
                <tr>
                    <td style="width: 15%">
                        Name:
                    </td>
                    <td style="width: 40%">
                        <div>
                            <div style="width: 95%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->patient }}</div>
                        </div>
                    </td>
                    <td style="width: 5%;text-align: right">
                        Age:
                    </td>
                    <td>
                        <div>
                            <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->age }}</div>
                        </div>
                    </td>
                    <td style="width: 5%">
                        Sex:
                    </td>
                    <td>
                        <div>
                            <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->sex }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>
                        <div>
                            <div style="width: 95%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->address }}</div>
                        </div>
                    </td>
                    <td>Ward/Room:</td>
                    <td colspan="3">
                        <div>
                            <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->ward }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Date Admitted:</td>
                    <td>
                        <div>
                            <div style="width: 95%" class="small fw-bold">
                                {{ $hideDetails ? '' : strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div id="middle_portion" class="{{ $hideDetails ? 'preserve-empty-space' : '' }}">
            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td style="width: 45%">
                        Chief Complaint/History of Present Illness:
                    </td>
                    <td>
                        <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($chief_complaint_lines[0] ?? '') }}</div>
                    </td>
                </tr>
                @for($i = 1; $i < max(count($chief_complaint_lines), 4); $i++)
                    <tr>
                        <td colspan="2">
                            <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($chief_complaint_lines[$i] ?? '') }}</div>
                        </td>
                    </tr>
                @endfor
            </table>
            <table style="width: 100%;margin-top: 20px">
                <tr>
                    <td style="width: 15%">
                        Diagnosis:
                    </td>
                    <td>
                        <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($diagnosis_lines[0] ?? '') }}</div>
                    </td>
                </tr>
                @for($i = 1; $i < max(count($diagnosis_lines), 4); $i++)
                    <tr>
                        <td colspan="2">
                            <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($diagnosis_lines[$i] ?? '') }}</div>
                        </td>
                    </tr>
                @endfor
            </table>
            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td style="width: 25%">
                        Medication on Board:
                    </td>
                    <td>
                        <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($medication_lines[0] ?? '') }}</div>
                    </td>
                </tr>
                @for($i = 1; $i < max(count($medication_lines), 4); $i++)
                    <tr>
                        <td colspan="2">
                            <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($medication_lines[$i] ?? '') }}</div>
                        </td>
                    </tr>
                @endfor
            </table>
            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td style="width: 15%">
                        Plan:
                    </td>
                    <td>
                        <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($plan_lines[0] ?? '') }}</div>
                    </td>
                </tr>
                @for($i = 1; $i < max(count($plan_lines), 4); $i++)
                    <tr>
                        <td colspan="2">
                            <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($plan_lines[$i] ?? '') }}</div>
                        </td>
                    </tr>
                @endfor
            </table>
            <table style="width: 100%; margin-top:30px">
                <tr>
                    <td></td>
                    <td style="width: 40%">
                        <div style="width: 100%" class="small fw-bold"></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center">ATTENDING PHYSICIAN</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center">
                        License No.
                        <span class="small" style="width: 75px"></span>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-top:{{$seal_margin_top}}px">
            <div class="fw-bold">(NOT VALID WITHOUT SEAL)</div>
            <table style="width: 100%">
                <tr>
                    <td style="width: 18%">OR NO</td>
                    <td style="width: 3%">:</td>
                    <td style="width: 49%">{{ $hideDetails ? '' : $certificate->or_no }}</td>
                    <td style="width: 30%"></td>
                </tr>
                <tr>
                    <td>AMOUNT</td>
                    <td>:</td>
                    @if(!$hideDetails && is_numeric($certificate->amount))
                        <td>₱{{ number_format($certificate->amount, 2) }}</td>
                    @else
                        <td>{{ $hideDetails ? '' : $certificate->amount }}</td>
                    @endif
                    <td style="text-align: right">
                        <small>MPS-REC-FM-04</small>
                    </td>
                </tr>
                <tr>
                    <td>Prepared by</td>
                    <td>:</td>
                    <td>
                        {{ $hideDetails ? '' : $certificate->prepared_by }}
                    </td>
                    <td style="text-align: right">
                        <small>07-Dec-18</small>
                    </td>
                </tr>
            </table>
        </div>
    </div>
```

Replace it with:

```blade
    <div class="container" style="margin-top: 70px">
        @foreach($pages as $pageIndex => $sections)
            <table style="width: 100%">
                <tr>
                    <td rowspan="3">
                        <div style="height: 100%;vertical-align: middle;text-align: center">
                            {!! QrCode::size(100)->generate($certificate->url) !!}
                        </div>
                    </td>
                    <td>
                        <div style="text-align: right">
                            Certificate No:
                            <div class="small fw-bold">{{ $hideDetails ? '' : $certificate->certificate_no }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="text-align: right">
                            Hospital No:
                            <div class="small fw-bold">{{ $hideDetails ? '' : $certificate->health_record_no }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="text-align: right">
                            Date:
                            <div class="small fw-bold">
                                {{ $hideDetails ? '' : strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_issued)->format('F j, Y')) }}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="{{ $hideDetails ? 'preserve-empty-space' : '' }}">
                <div class="certificate-title">
                    MEDICAL ABSTRACT
                </div>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 15%">
                            Name:
                        </td>
                        <td style="width: 40%">
                            <div>
                                <div style="width: 95%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->patient }}</div>
                            </div>
                        </td>
                        <td style="width: 5%;text-align: right">
                            Age:
                        </td>
                        <td>
                            <div>
                                <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->age }}</div>
                            </div>
                        </td>
                        <td style="width: 5%">
                            Sex:
                        </td>
                        <td>
                            <div>
                                <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->sex }}</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>
                            <div>
                                <div style="width: 95%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->address }}</div>
                            </div>
                        </td>
                        <td>Ward/Room:</td>
                        <td colspan="3">
                            <div>
                                <div style="width: 100%" class="small fw-bold">{{ $hideDetails ? '' : $certificate->ward }}</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Date Admitted:</td>
                        <td>
                            <div>
                                <div style="width: 95%" class="small fw-bold">
                                    {{ $hideDetails ? '' : strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="middle_portion_{{ $pageIndex }}" class="{{ $hideDetails ? 'preserve-empty-space' : '' }}">
                @foreach($sections as $section)
                    <table style="width: 100%; margin-top: 20px">
                        <tr>
                            <td style="width: {{ $section['width'] }}%">
                                {{ $section['label'] }}
                            </td>
                            <td>
                                <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($section['lines'][0] ?? '') }}</div>
                            </td>
                        </tr>
                        @for($i = 1; $i < max(count($section['lines']), 4); $i++)
                            <tr>
                                <td colspan="2">
                                    <div class="clinical-line fw-bold">{{ $hideDetails ? '' : ($section['lines'][$i] ?? '') }}</div>
                                </td>
                            </tr>
                        @endfor
                    </table>
                @endforeach
                <table style="width: 100%; margin-top:30px">
                    <tr>
                        <td></td>
                        <td style="width: 40%">
                            <div style="width: 100%" class="small fw-bold"></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center">ATTENDING PHYSICIAN</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center">
                            License No.
                            <span class="small" style="width: 75px"></span>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="margin-top:{{$seal_margin_top}}px">
                <div class="fw-bold">(NOT VALID WITHOUT SEAL)</div>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 18%">OR NO</td>
                        <td style="width: 3%">:</td>
                        <td style="width: 49%">{{ $hideDetails ? '' : $certificate->or_no }}</td>
                        <td style="width: 30%"></td>
                    </tr>
                    <tr>
                        <td>AMOUNT</td>
                        <td>:</td>
                        @if(!$hideDetails && is_numeric($certificate->amount))
                            <td>₱{{ number_format($certificate->amount, 2) }}</td>
                        @else
                            <td>{{ $hideDetails ? '' : $certificate->amount }}</td>
                        @endif
                        <td style="text-align: right">
                            <small>MPS-REC-FM-04</small>
                        </td>
                    </tr>
                    <tr>
                        <td>Prepared by</td>
                        <td>:</td>
                        <td>
                            {{ $hideDetails ? '' : $certificate->prepared_by }}
                        </td>
                        <td style="text-align: right">
                            <small>07-Dec-18</small>
                        </td>
                    </tr>
                </table>
            </div>
            @if(!$loop->last)
                <div style="page-break-after: always;"></div>
            @endif
        @endforeach
    </div>
```

(`id="middle_portion"` becomes `id="middle_portion_{{ $pageIndex }}"` since the element now repeats once per page — duplicate HTML ids across the page loop would otherwise be invalid.)

- [ ] **Step 3: Manually verify with a standalone render script**

Run this from the project root (adjust the path if your checkout differs from `C:/wamp64/projects/qrcode-tracker`):

```bash
cat > /tmp/verify_pages.php << 'PHPEOF'
<?php
require 'C:/wamp64/projects/qrcode-tracker/vendor/autoload.php';
$app = require_once 'C:/wamp64/projects/qrcode-tracker/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$certificate = (object)[
    'url' => 'https://example.com/test', 'certificate_no' => 'TEST01', 'health_record_no' => 'HR-TEST',
    'date_issued' => now(), 'patient' => 'Test Patient', 'age' => '30', 'sex' => 'MALE',
    'address' => 'Test Address', 'ward' => 'Ward 1', 'date_examined' => now(),
    'or_no' => 'OR-1', 'amount' => 50.00, 'prepared_by' => 'Tester',
];
$diagnosis = collect([(object)['diagnosis' => 'D1']]);
$chief_complaints = collect([(object)['chief_complaint' => 'C1']]);
$medications = collect([(object)['medication' => 'M1']]);
$plans = collect([(object)['plan' => 'P1']]);

// Scenario: Diagnosis + Chief Complaint on page 1, Plan on page 2, Medication on page 1 (default)
$html = view('pdf.medical_abstract', [
    'certificate' => $certificate, 'diagnosis' => $diagnosis, 'chief_complaints' => $chief_complaints,
    'medications' => $medications, 'plans' => $plans, 'hide_details' => false,
    'd_margin_top' => 0, 'd_margin_bottom' => 0, 's_margin_top' => 0, 's_margin_bottom' => 0, 'seal_margin_top' => 0,
    'chief_complaint_page' => 1, 'diagnosis_page' => 1, 'medication_page' => 1, 'plan_page' => 2,
])->render();

echo "RENDER OK, length=" . strlen($html) . "\n";
echo "page-break count (expect 1): " . substr_count($html, 'page-break-after: always') . "\n";
echo "Certificate No appears twice (once per page, expect 2): " . substr_count($html, 'TEST01') . "\n";
echo "ATTENDING PHYSICIAN appears twice (expect 2): " . substr_count($html, 'ATTENDING PHYSICIAN') . "\n";
echo "NOT VALID WITHOUT SEAL appears twice (expect 2): " . substr_count($html, 'NOT VALID WITHOUT SEAL') . "\n";
echo "C1/D1/M1 all present: " . ((str_contains($html,'C1') && str_contains($html,'D1') && str_contains($html,'M1')) ? 'YES' : 'NO') . "\n";
echo "P1 present: " . (str_contains($html,'P1') ? 'YES' : 'NO') . "\n";

// Scenario: everything defaults to page 1 (omit page params entirely) -> must match old single-page behavior
$html2 = view('pdf.medical_abstract', [
    'certificate' => $certificate, 'diagnosis' => $diagnosis, 'chief_complaints' => $chief_complaints,
    'medications' => $medications, 'plans' => $plans, 'hide_details' => false,
    'd_margin_top' => 0, 'd_margin_bottom' => 0, 's_margin_top' => 0, 's_margin_bottom' => 0, 'seal_margin_top' => 0,
])->render();
echo "\nDefault (no page params) -> page-break count (expect 0): " . substr_count($html2, 'page-break-after: always') . "\n";
echo "Default -> Certificate No appears once (expect 1): " . substr_count($html2, 'TEST01') . "\n";
PHPEOF
php /tmp/verify_pages.php
rm -f /tmp/verify_pages.php
```

Expected output: render succeeds for both scenarios with no PHP errors; the first scenario shows exactly 1 page-break, the header/signature/footer markers each appearing twice (once per page), and all 4 section values present; the second scenario (no page params at all) shows 0 page-breaks and the header marker appearing exactly once — confirming the no-customization case is unchanged from before this task.

- [ ] **Step 4: Commit**

```bash
git add resources/views/pdf/medical_abstract.blade.php
git commit -m "Render medical_abstract PDF as multiple pages grouped by per-section page assignment"
```

## Context

This is the biggest task in this plan — it restructures the template's body into a loop, so it's done as one atomic change (not split into multiple commits) to avoid leaving the template in a half-restructured, non-rendering state partway through. The 4 previously-separate clinical-section `<table>` blocks collapse into one `@foreach($sections as $section)` loop reusing the same minimum-4-lines-padding logic each already had (now parameterized by `$section['label']`, `$section['width']`, `$section['lines']` instead of 4 hardcoded copies). `array_filter` on `$sectionDefs` preserves the original key order (`chief_complaint`, `diagnosis`, `medication`, `plan`), so sections within a page always render in that same relative order regardless of which subset lands on a given page.

---

### Task 6: End-to-end manual verification

**Files:** none (verification only)

- [ ] **Step 1: Verify default behavior (no customization) matches today's single-page output**

In the browser: open a medical_abstract certificate's print preview without touching the new dropdowns (leave them at their default of page 1). Confirm the printed/previewed output is a single page, identical in layout to before this feature — header once, all 4 sections in the middle, footer once.

- [ ] **Step 2: Verify a multi-page split**

Open the print-settings modal for a medical_abstract certificate. Confirm the 4 new dropdowns ("Chief Complaint Page", "Diagnosis Page", "Medication on Board Page", "Plan Page") appear, each defaulting to 1. Set "Plan Page" to 2, leave the rest at 1, and click PRINT.

Expected: the preview opens with 2 pages (separated by a page break). Page 1 shows the header, patient info, Chief Complaint/Diagnosis/Medication sections, attending physician signature, and footer. Page 2 shows the header, patient info (repeated), only the Plan section, the attending physician signature (repeated), and the footer (repeated).

- [ ] **Step 3: Verify the dropdowns are hidden for other certificate types**

Open the print-settings modal for a non-medical_abstract certificate (e.g. COC or Ordinary). Confirm the 4 new page-assignment dropdowns do NOT appear, and printing that certificate still works exactly as before.

- [ ] **Step 4: Verify skipped-page compaction**

Set "Diagnosis Page" to 1 and "Plan Page" to 3 (skip page 2 entirely, leave Chief Complaint/Medication at 1). Print preview.

Expected: still only 2 physical pages — page 1 has Chief Complaint/Diagnosis/Medication, page 2 has Plan. No blank page appears for the skipped "page 2" label.
