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
        }

        .certificate-text {
            text-align: center;
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
            text-align: center;
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
            text-align: center;
            margin-left: 400px;
            margin-right: 30px;
            width: 250px;
        }

        .mt-3 {
            margin-top: 30px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <table style="width: 100%">
        <tr>
            <td>
                {!! QrCode::size(100)->generate($certificate->url) !!}
            </td>
            <td>
                <div class="certificate-details">
                    <div>
                        Certificate No:
                        <div class="small">{{ $certificate->certificate_no }}</div>
                    </div>
                    <div>
                        Health Record No:
                        <div class="small">{{ $certificate->health_record_no }}</div>
                    </div>
                    <div class="mt-1">
                        Date:
                        <div
                            class="small">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_issued)->format('F j, Y')) }}</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="certificate-title">
        MEDICAL CERTIFICATE
    </div>
    <div style="margin-top:30px">
        TO WHOM IT MAY CONCERN:
    </div>
    <table style="width: 100%;margin-top:15px">
        <tr>
            <td style="width: 53%">This is to certify that based on the Hospital record,</td>
            <td class="border-bottom text-center" style="width: 37%">
                {{ $certificate->patient }}
            </td>
            <td style="width: 10%">
                <div style="margin-left: 5px;">of</div>
            </td>
        </tr>
    </table>
    <table style="width: 100%;margin-top:15px">
        <tr>
            <td class="border-bottom text-center" style="width: 53%">{{ $certificate->address }}</td>
            <td class="border-bottom text-center" style="width: 15%">, {{ $certificate->age }} </td>
            <td class="border-bottom text-center" style="width: 15%">, {{ $certificate->sex }}</td>
            <td style="width: 10%">
                <div style="margin-left: 5px;">, was</div>
            </td>
        </tr>
        <tr class="text-center">
            <td><small>(Patient's complete address)</small></td>
            <td><small>(Age)</small></td>
            <td><small>(Sex)</small></td>
            <td></td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 43%">examined and treated in the Hospital on</td>
            <td class="border-bottom text-center"
                style="width: 25%">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}
                .
            </td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td><small>(Date of Consultation)</small></td>
            <td></td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 20%">under the care of</td>
            <td class="border-bottom text-center" style="width: 49%">{{ $certificate->doctor }}</td>
            <td style="width: 2%">-</td>
            <td class="text-center" style="width: 18%">
                <div><u>{{ $certificate->doctor_license }}</u></div>
            </td>
            <td></td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td><small>(Attending Physician)</small></td>
            <td></td>
            <td><small>(License Number)</small></td>
            <td></td>
        </tr>
    </table>
    <div>
        with the following findings and or diagnosis:
    </div>
    <div style="margin-top:10px">DIAGNOSIS:</div>
    <div style="color:white">A</div>
    <div style="color:white">A</div>
    <div>
        @for($i=0; $i<count($diagnosis); $i++)
            <div>{{ $diagnosis[$i]->diagnosis }}</div>
        @endfor
    </div>
    <div style="color:white">A</div>
    <div style="color:white">A</div>
    <div class="certificate-text">
        <table style="width: 100%">
            <tr>
                <td style="width: 55%">This certification is being issued at the requested of</td>
                <td style="width: 45%">
                    <div class="border-bottom ml-1">{{ $certificate->requesting_person }}</div>
                </td>
            </tr>
        </table>
    </div>
    <div>
        For (Please tick the applicable box below.):
        <div style="margin-left: 50px;">
            <div>
                <div style="display: inline">
                    @if($certificate->purpose == 'Financial and Medical Assistance Program available in the hospital')
                        <input type="checkbox" checked disabled/>
                    @else
                        <input type="checkbox" disabled/>
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
                        <input type="checkbox" checked disabled/>
                    @else
                        <input type="checkbox" disabled/>
                    @endif
                </div>
                <span>School Related Purposes, except for insurance claims or any legal claim</span>
            </div>
            <div>
                <div style="display: inline">
                    @if($certificate->purpose == 'Work Related-Purposes, except for insurance claims or any legal claim')
                        <input type="checkbox" checked disabled/>
                    @else
                        <input type="checkbox" disabled/>
                    @endif
                </div>
                <span>Work Related-Purposes, except for insurance claims or any legal claim</span>
            </div>
        </div>
    </div>

    <div style="margin-top:100px">
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
                <td>₱{{ number_format($certificate->amount,2) }}</td>
                <td>
                    <small>MPS-REC-FM-06</small>
                </td>
            </tr>
            <tr>
                <td>Prepared by</td>
                <td>:</td>
                <td>
                    {{ \Illuminate\Support\Facades\Auth::user()->fname }}
                    {{ \Illuminate\Support\Facades\Auth::user()->mname ? \Illuminate\Support\Facades\Auth::user()->mname[0].'.' : '' }}
                    {{ \Illuminate\Support\Facades\Auth::user()->lname }}
                </td>
                <td>
                    <small>07-Dec-18</small>
                </td>
            </tr>
        </table>
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
