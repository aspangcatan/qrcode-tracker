<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MAIPP MEDICAL CERTIFICATE</title>
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

        .certificate-text > div {
            margin-top: 20px;
        }

        .long {
            text-align: center;
            width: 390px; /* Adjust the width as needed */
            border-bottom: 1px solid black;
            display: inline-block;
        }

        .medium {
            margin-left: 20px;
            text-align: center;
            width: 300px; /* Adjust the width as needed */
            border-bottom: 1px solid black;
            display: inline-block;
        }

        .small {
            text-align: center;
            width: 180px; /* Adjust the width as needed */
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
            border-spacing: 0 !important; /* Set border-spacing to 0 for the specific class */
        }
    </style>
</head>
<body>
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
                    <div class="small fw-bold">{{ $certificate->certificate_no }}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="text-align: right">
                    Hospital No:
                    <div class="small fw-bold">{{ $certificate->health_record_no }}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="text-align: right">
                    Date:
                    <div
                        class="small fw-bold">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_issued)->format('F j, Y')) }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="certificate-title">
        CERTIFICATION
    </div>
    <div style="margin-top:30px">
        To whom it may concern:
    </div>
    <table style="width: 100%;margin-top:15px">
        <tr>
            <td style="width: 60%">
                <p>This is to certify that based on the Hospital record,</p>
            </td>
            <td class="border-bottom text-center fw-bold" style="width: 37%">
                {{ $certificate->patient }}
            </td>
            <td style="width: 10%">
                <div style="margin-left: 5px;">of</div>
            </td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td>
                <small>Patient's name</small>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td class="border-bottom text-center fw-bold">
                {{ $certificate->address }}
            </td>
            <td>,</td>
            <td class="border-bottom text-center fw-bold">
                {{ $certificate->age }}
            </td>
            <td>,</td>
            <td class="border-bottom text-center fw-bold">
                {{ $certificate->sex }}
            </td>
            <td>
                <p>, was</p>
            </td>
        </tr>
        <tr class="text-center">
            <td>
                <small>Address</small>
            </td>
            <td></td>
            <td>
                <small>Age</small>
            </td>
            <td></td>
            <td>
                <small>Gender</small>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 30%">
                <p>examined and treated/confined in this hospital on</p>
            </td>
            <td class="border-bottom text-center fw-bold"
                style="width: 25%">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}
            </td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td><small>Date of consultation</small></td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 20%">
                <p>under the care of</p>
            </td>
            <td class="border-bottom text-center fw-bold" style="width: 49%">{{ $certificate->doctor }}</td>
            <td style="width: 2%" class="fw-">-</td>
            <td class="border-bottom text-center fw-bold">
                {{ $certificate->doctor_license }}
            </td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td><small>Attending Physician</small></td>
            <td></td>
            <td><small>License Number</small></td>
        </tr>
        <tr>
            <td colspan="2">
                <p style="padding-top: 10px">with the following working impression/s:</p>
            </td>
        </tr>
    </table>

    <div style="margin-left: 90px;margin-top:{{$d_margin_top}}px;margin-bottom:{{$d_margin_bottom}}px;text-transform: uppercase">
        @for($i=0; $i<count($diagnosis); $i++)
            <div class="centered-element">{!! $diagnosis[$i]->diagnosis !!}</div>
        @endfor
    </div>

    <table style="width: 100%">
        <tr>
            <td style="width: 60%">
                <p>This certification is being issued at the request of</p>
            </td>
            <td style="width: 40%">
                <div class="border-bottom text-center fw-bold">{{ $certificate->requesting_person }}</div>
            </td>
            <td>for</td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td>
                <small>Name of person requesting</small>
            </td>
        </tr>
    </table>
    <div>
        (Please tick the applicable box below.):
        <div style="margin-left: 50px;">
            <div>
                <div style="display: inline">
                    @if($certificate->purpose == 'Financial and Medical Assistance Program available in the hospital')
                        <input type="checkbox" checked/>
                    @else
                        <input type="checkbox"/>
                    @endif
                </div>
                <span>Financial and Medical Assistance Program available in the hospital</span>
                @if($certificate->second_purpose)
                    <div style="display: inline;margin-left: 80px"><u>{{ $certificate->second_purpose }}</u></div>
                @endif
            </div>
            <div>
                <div style="display: inline">
                    @if($certificate->purpose == 'School Related Purposes, except for insurance claims or any legal claim')
                        <input type="checkbox" checked/>
                    @else
                        <input type="checkbox"/>
                    @endif
                </div>
                <span>School Related Purposes, except for insurance claims or any legal claim</span>
            </div>
            <div>
                <div style="display: inline">
                    @if($certificate->purpose == 'Work Related-Purposes, except for insurance claims or any legal claim')
                        <input type="checkbox" checked/>
                    @else
                        <input type="checkbox"/>
                    @endif
                </div>
                <span>Work Related-Purposes, except for insurance claims or any legal claim</span>
            </div>
        </div>
    </div>

    <div style="margin-top:{{$seal_margin_top}}px">
        <div class="fw-bold">NOT FOR MEDICO LEGAL PURPOSES</div>
        <div class="fw-bold" style="margin-top: 20px">(NOT VALID WITHOUT SEAL)</div>
        <table style="width: 100%">
            <tr>
                <td style="width: 18%">OR NO</td>
                <td style="width: 3%">:</td>
                <td style="width: 49%">{{ $certificate->or_no }}</td>
                <td style="width: 30%"></td>
            </tr>
            <tr>
                <td>AMOUNT</td>
                <td>:</td>
                @if(is_numeric($certificate->amount))
                    <td>₱{{ number_format($certificate->amount,2) }}</td>
                @else
                    <td>{{ $certificate->amount }}</td>
                @endif
                <td>
                    <small></small>
                </td>
            </tr>
            <tr>
                <td>Prepared by</td>
                <td>:</td>
                <td>
                    {{ $certificate->prepared_by }}
                </td>
                <td>
                    <small></small>
                </td>
            </tr>
        </table>
    </div>
    <div style="float:right;margin-top:{{$s_margin_top}}px;font-size: 13px">
        <div>AHQM-REC-FM-03 Rev.0</div>
        <div>April 1, 2024</div>
    </div>
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
