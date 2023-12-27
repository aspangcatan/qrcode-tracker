<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ordinary Medical Certificate</title>
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
<div style="color: white">A</div>
<div style="color: white">A</div>
<div style="color: white">A</div>
<div class="container">
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
                    Health Record No:
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
        {{ $title }}
    </div>
    <div class="certificate-text" style="text-align: start">
        <table style="width: 100%">
            <tr>
                <td>
                    <p>This is to certify that</p>
                </td>
                <td class="border-bottom text-center fw-bold" style="width: 50%">
                    {{ $certificate->patient }}
                </td>
                <td>,</td>
                <td class="border-bottom text-center fw-bold" style="width: 20%">
                    {{ $certificate->age }}
                </td>
                <td>of</td>
            </tr>
            <tr class="text-center">
                <td></td>
                <td>
                    <small>Name of Patient</small>
                </td>
                <td></td>
                <td>
                    <small>Age</small>
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td class="border-bottom text-center fw-bold" style="width: 50%">
                    {{ $certificate->address }}
                </td>
                <td>
                    <p>was examined and treated / confined in</p>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <small>Address</small>
                </td>
            </tr>
        </table>
        <table style="width: 100%;text-align: start">
            <tr>
                <td>
                    <p>this hospital on/from</p>
                </td>
                <td class="border-bottom text-center fw-bold" style="width: 26%">
                    {{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}
                </td>
                <td> to</td>
                <td class="border-bottom text-center fw-bold" style="width: 26%">
                    @if($certificate->date_discharged)
                        {{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_discharged)->format('F j, Y')) }}
                    @else
                        still admitted
                    @endif
                </td>
                <td style="width: 20%">
                    <p>with the following</p>
                </td>
            </tr>
            <tr class="text-center">
                <td></td>
                <td>
                   <small>Date of admission</small>
                </td>
                <td></td>
                <td>
                    <small>Date of discharge</small>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="padding-top: 10px">
                        <p>findings and/or diagnosis:</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div style="color:white">A</div>
    <div style="color:white">A</div>
    <div class="certificate-diagnosis" style="margin-left: 130px">
        @for($i=0; $i<count($diagnosis); $i++)
            <div>{!! $diagnosis[$i]->diagnosis !!}</div>
        @endfor
    </div>
    <div style="color:white">A</div>
    <div style="color:white">A</div>
    <div class="certificate-text">
        <table style="width: 100%">
            <tr>
                <td style="width: 60%">
                    <p>This certification is being issued at the request of</p>
                </td>
                <td>
                    <div class="border-bottom text-center fw-bold ml-1">{{ $certificate->requesting_person }}</div>
                </td>
            </tr>
            <tr class="text-center">
                <td></td>
                <td>
                    <small>Name of Person Requesting</small>
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td style="width: 2%">for</td>
                <td style="width: 30%">
                    <div class="border-bottom text-center fw-bold ml-1">{{ $certificate->purpose }}</div>
                </td>
                <td style="width: 20%"></td>
            </tr>
            <tr class="text-center">
                <td></td>
                <td>
                    <small>Purpose</small>
                </td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="doctor-container mt-5">
        <table style="width: 100%">
            <tr>
                <td style="width: 50%"></td>
                <td style="width: 40%">
                    <u class="fw-bold">{{ $certificate->doctor }}</u>
                </td>
                <td style="width: 10%"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    {{ $certificate->doctor_designation }}
                </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    License No.: <span class="ml-1"><u>{{ $certificate->doctor_license }}</u></span>
                </td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="mt-3">
        <div>(NOT VALID WITHOUT SEAL)</div>
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
    <div style="float:right;margin-top:30px;font-size: 13px">
        <div>MPS - REC - FM - 06</div>
        <div>07-Dec-18</div>
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
