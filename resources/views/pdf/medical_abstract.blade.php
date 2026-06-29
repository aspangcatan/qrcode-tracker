<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MEDICAL ABSTRACT</title>
    <style>
        @media print {
            body {
                margin: 0 !important;
                width: unset !important;
            }
        }

        body {
            padding: 0 !important;
            margin-left: 30%;
            margin-right: 30%;
            font-size: 16px;
            font-family: Arial, sans-serif;
        }

        .fw-bold {
            font-weight: bold;
            text-transform: uppercase;
        }

        .container {
            margin-top: 100px;
            margin-left: 20px;
            margin-right: 20px;
        }

        .banner img {
            display: block;
            max-width: 100%;
            width: 100%;
            height: auto;
        }

        .certificate-details {
            text-align: right;
            margin-top: 10px;
        }

        .certificate-details p {
            margin: 10px 0;
        }

        .certificate-details span {
            text-decoration: underline;
        }

        .certificate-title {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 30px;
        }

        .certificate-text {
            margin-top: 20px;
        }

        .certificate-text>div {
            margin-top: 20px;
        }

        .long {
            text-align: center;
            width: 390px;
            /* Adjust the width as needed */
            border-bottom: 1px solid black;
            display: inline-block;
        }

        .medium {
            margin-left: 20px;
            text-align: center;
            width: 300px;
            /* Adjust the width as needed */
            border-bottom: 1px solid black;
            display: inline-block;
        }

        .small {
            text-align: center;
            width: 180px;
            /* Adjust the width as needed */
            border-bottom: 1px solid black;
            display: inline-block;
        }

        .certificate-diagnosis {
            margin-top: 20px;
            text-transform: uppercase;
        }

        .mt-1 {
            margin-top: 10px;
        }

        /* Specific styling for the label */
        .label {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .border-bottom {
            border-bottom: 1px solid black;
        }

        .ml-1 {
            margin-left: 10px;
        }

        .mr-3 {
            margin-right: 30px;
        }

        .doctor-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .doctor-container div {
            text-align: center;
        }

        .mt-3 {
            margin-top: 30px;
        }

        .mt-5 {
            margin-top: 70px
        }

        .text-center {
            text-align: center;
        }

        table {
            border-collapse: separate;
            border-spacing: 0 3px;
        }

        table p {
            word-spacing: 5px;
            padding: 0px;
            margin: 0px;
        }

        table tr.no-spacing {
            border-spacing: 0 !important;
            /* Set border-spacing to 0 for the specific class */
        }

        .preserve-empty-space {
            visibility: hidden;
        }

        .clinical-line {
            text-align: left;
            width: 100%;
            display: block;
        }
    </style>
</head>

<body>
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

        // A blank line still needs a real character in it, otherwise the
        // empty <div> collapses to zero height instead of matching the
        // line-height of a row that has text in it.
        $renderLine = function ($section, $i) use ($hideDetails) {
            if ($hideDetails || !isset($section['lines'][$i])) {
                return '&nbsp;';
            }
            return e($section['lines'][$i]);
        };

        // Chief Complaint has the longest label, so its column width is the
        // basis every section's label column uses to keep all value columns
        // aligned to the same starting x position.
        $labelColumnWidth = 33;

        $sectionDefs = [
            'chief_complaint' => ['label' => 'Chief Complaint/History of Present Illness:', 'width' => $labelColumnWidth, 'lines' => $chief_complaint_lines, 'page' => max(1, (int) ($chief_complaint_page ?? 1))],
            'diagnosis' => ['label' => 'Diagnosis:', 'width' => $labelColumnWidth, 'lines' => $diagnosis_lines, 'page' => max(1, (int) ($diagnosis_page ?? 1))],
            'medication' => ['label' => 'Medication on Board:', 'width' => $labelColumnWidth, 'lines' => $medication_lines, 'page' => max(1, (int) ($medication_page ?? 1))],
            'plan' => ['label' => 'Plan:', 'width' => $labelColumnWidth, 'lines' => $plan_lines, 'page' => max(1, (int) ($plan_page ?? 1))],
        ];

        $pages = collect($sectionDefs)
            ->pluck('page')
            ->unique()
            ->sort()
            ->values()
            ->map(fn($pageNum) => array_filter($sectionDefs, fn($s) => $s['page'] === $pageNum))
            ->values();
    @endphp
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
                                <div style="width: 95%; text-align: left" class="small fw-bold">{{ $hideDetails ? '' : $certificate->patient }}</div>
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
                                <div style="width: 95%; text-align: left" class="small fw-bold">{{ $hideDetails ? '' : $certificate->address }}</div>
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
                                <div style="width: 95%; text-align: left" class="small fw-bold">
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
                            <td style="width: {{ $section['width'] }}%; vertical-align: top">
                                {{ $section['label'] }}
                            </td>
                            <td style="vertical-align: top">
                                <div class="clinical-line fw-bold">{!! $renderLine($section, 0) !!}</div>
                            </td>
                        </tr>
                        @for($i = 1; $i < count($section['lines']); $i++)
                            <tr>
                                <td style="width: {{ $section['width'] }}%; vertical-align: top"></td>
                                <td style="vertical-align: top">
                                    <div class="clinical-line fw-bold">{!! $renderLine($section, $i) !!}</div>
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
    <script>
        // Disable right-click
        document.addEventListener('contextmenu', event => event.preventDefault());
        // Disable keyboard shortcuts (F12, Ctrl+Shift+I, etc.)
        document.onkeydown = function (e) {
            if ((e.keyCode === 85 || e.keyCode === 67 || e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 123)) {
                e.preventDefault();
                return false;
            }
        };
    </script>
</body>

</html>
