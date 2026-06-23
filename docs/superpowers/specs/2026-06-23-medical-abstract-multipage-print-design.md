# Medical Abstract: Per-Section Page Assignment for Printing — Design

## Context

The `medical_abstract` certificate PDF (`resources/views/pdf/medical_abstract.blade.php`) prints Chief Complaint, Diagnosis, Medication on Board, and Plan as repeatable lines on a single page. When a section's content is long (many entries, or entries with multiple `<br>`-separated lines — see the prior design doc, [2026-06-23-medical-abstract-clinical-fields-design.md](2026-06-23-medical-abstract-clinical-fields-design.md)), there's no way to control how the certificate spans multiple physical pages — it just keeps growing the single page.

The print settings modal (`heading_modal` in `resources/views/modals/certificate.blade.php`) already lets staff configure print-time options (margins, "with Myla assignatory", "hide details") before opening the print-preview tab (`ApplicationController::printPreview()` → `pdf.medical_abstract`). This feature adds 4 new options to that same modal, exclusive to `medical_abstract`, letting staff assign each of the 4 clinical sections to a specific page number — so a long Plan section, for example, can be pushed to page 2 while everything else stays on page 1.

## Goal

Let staff choose, per `medical_abstract` print, which page (1–4) each of the 4 clinical sections appears on. Every page that has at least one section assigned to it gets a full copy of the certificate's header (QR code, Certificate No/Hospital No/Date), patient info (Name/Age/Sex/Address/Ward/Date Admitted), the Attending Physician signature line, and the seal/OR No/Amount/Prepared-by footer — only the clinical section content in the middle differs per page.

## Decisions

- **Scope:** exclusive to `medical_abstract`. The 4 new dropdowns in `heading_modal` are hidden (and reset to their default of page 1) for every other certificate type, mirroring how the ADD CHIEF COMPLAINT/MEDICATION/PLAN buttons were scoped to `medical_abstract` only in the prior feature.
- **Control type:** a `<select>` dropdown per section, options 1–4 (not a free-form number input, and not capped any higher — 4 sections means 4 is the worst-case page count where every section gets its own page).
- **Default:** every section defaults to page 1. If nothing is customized, output is identical to today's single-page certificate — fully backward compatible.
- **Attending Physician signature line:** repeats on every page (not just the last page, and not pinned to page 1).
- **Header/patient-info/footer:** repeat identically on every page, using the same `$hideDetails`-gated values already in place today.
- **Skipped page numbers compact:** if sections are assigned to pages 1 and 3 but nothing is assigned to page 2, only 2 physical pages print (page 3's content becomes the 2nd physical sheet). No blank intermediate pages.
- **Margins** (`d_margin_top`, `d_margin_bottom`, `s_margin_top`, `seal_margin_top`) apply uniformly to every generated page — no per-page margin overrides.
- **Page break mechanism:** CSS `page-break-after: always` between page groups (not after the last one). This is plain HTML viewed in a browser tab and printed via the browser's own print dialog — there's no real PDF file being generated/merged at this stage, so CSS page-break is sufficient and is already supported by this template's rendering path (DomPDF via `barryvdh/laravel-dompdf`, and by every browser's print engine for the on-screen preview).

## Frontend

### `resources/views/modals/certificate.blade.php` (`heading_modal`)

Add 4 new `form-floating` blocks, each a `<select>` with options 1–4 (default `1` selected), ids `chief_complaint_page`, `diagnosis_page`, `medication_page`, `plan_page`, each wrapped with a shared class (e.g. `medical-abstract-only`) plus `d-none` by default — mirroring the `list-field-btn`/`d-none` pattern used for the ADD CHIEF COMPLAINT/MEDICATION/PLAN buttons.

### `resources/views/js/home.blade.php`

- `printPreview(id)` (the function that opens `heading_modal`, currently only resets margin defaults): look up the certificate's type the same way `editCertificate(id)` already does — `$("#certificate_id_" + id + " td:eq(0)").text().trim()` — then toggle `.medical-abstract-only` visibility based on whether `type === "medical_abstract"`, and set all 4 new dropdowns to their default value of `1`.
- `btn_print_certificate`'s click handler: read the 4 new dropdown values and append them to the print-preview URL as query params (`chief_complaint_page`, `diagnosis_page`, `medication_page`, `plan_page`), the same way `d_margin_top` etc. already are. Always included regardless of certificate type — harmless for other types since the backend only consumes these in the `medical_abstract` case.

## Backend

### `ApplicationController::printPreview()`

In the `medical_abstract` case, pass the 4 new request values straight into the view array (`'chief_complaint_page' => $request->chief_complaint_page`, etc. — no validation or defaulting here; the Blade template handles missing/non-numeric values by defaulting to `1`).

## PDF template (`resources/views/pdf/medical_abstract.blade.php`)

In the existing `@php` block (where `$hideDetails` and the `<br>`-splitting closure already live), add:

```php
$sectionDefs = [
    'chief_complaint' => ['label' => 'Chief Complaint/History of Present Illness:', 'width' => 45, 'lines' => $chief_complaint_lines, 'page' => max(1, (int) ($chief_complaint_page ?? 1))],
    'diagnosis'        => ['label' => 'Diagnosis:', 'width' => 15, 'lines' => $diagnosis_lines, 'page' => max(1, (int) ($diagnosis_page ?? 1))],
    'medication'       => ['label' => 'Medication on Board:', 'width' => 25, 'lines' => $medication_lines, 'page' => max(1, (int) ($medication_page ?? 1))],
    'plan'             => ['label' => 'Plan:', 'width' => 15, 'lines' => $plan_lines, 'page' => max(1, (int) ($plan_page ?? 1))],
];

$pages = collect($sectionDefs)
    ->pluck('page')
    ->unique()
    ->sort()
    ->values()
    ->map(fn($pageNum) => array_filter($sectionDefs, fn($s) => $s['page'] === $pageNum))
    ->values();
```

(`array_filter` preserves the original `$sectionDefs` key order — `chief_complaint`, `diagnosis`, `medication`, `plan` — within each page's subset, so section order within a page never needs separate sorting.)

Restructure the body so the QR/Certificate-No/Hospital-No/Date header table, the Patient info table, the clinical-section tables, the Attending Physician signature table, and the seal/footer block are all inside a single `@foreach($pages as $pageIndex => $sections) ... @endforeach`. Inside the loop:

- Header table and Patient info table: unchanged markup, just now inside the loop (repeats every page).
- Clinical sections: replace the 4 separate copy-pasted `<table>` blocks with one `@foreach($sections as $section)` loop that renders a `<table>` using `$section['label']`, `$section['width']`, and `$section['lines']` — reusing the existing minimum-4-lines logic (`@for($i = 1; $i < max(count($section['lines']), 4); $i++)`) unchanged in shape, just parameterized.
- Attending Physician signature table: unchanged markup, now inside the loop (repeats every page).
- Footer (seal/OR No/Amount/Prepared-by): unchanged markup, now inside the loop (repeats every page).
- After each page except the last: `@if(!$loop->last) <div style="page-break-after: always;"></div> @endif`.

## Out of scope

- No changes to any certificate type other than `medical_abstract`.
- No per-page margin overrides.
- No UI indication in the data-entry form (`forms/medical_abstract.blade.php`) of which page a section will print on — page assignment is purely a print-time setting in `heading_modal`.
- No real PDF-merging library — this stays plain HTML + CSS page-break, consistent with how this template already works.
