<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MEDICO LEGAL CERTIFICATE</title>
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
                    <div class="small">{{ $certificate->certificate_no }}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="text-align: right">
                    Health Record No:
                    <div class="small">{{ $certificate->health_record_no }}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="text-align: right">
                    Date:
                    <div
                        class="small">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_issued)->format('F j, Y')) }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="certificate-title">
        MEDICO LEGAL CERTIFICATE
    </div>
    <table style="width: 100%;margin-top:15px">
        <tr>
            <td style="width: 25%">
                <div style="margin-left: 10px">This is to certify that</div>
            </td>
            <td class="border-bottom text-center" style="width: 50%">
                {{ $certificate->patient }}
            </td>
            <td style="width: 30%">, {{ $certificate->age }} </td>
        </tr>
        <tr>
            <td colspan="4">
                <div style="word-spacing: 10px;">
                    @if(strtoupper($certificate->sex) == 'MALE') <u>male</u>
                    @else male
                    @endif /
                    @if(strtoupper($certificate->sex) == 'FEMALE')
                        <u>female</u>
                    @else female
                    @endif ,
                    @if(strtoupper($certificate->civil_status) == 'SINGLE')<u>single</u>
                    @else single
                    @endif /
                    @if(strtoupper($certificate->civil_status) == 'MARRIED')<u>married</u>
                    @else married
                    @endif /
                    @if(strtoupper($certificate->civil_status) == 'CHILD')<u>child</u>
                    @else child
                    @endif /
                    @if(strtoupper($certificate->civil_status) == 'WIDOW/ER')<u>widow/er</u>
                    @else widow/er
                    @endif, Filipino, and a resident of
                </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 45%" class="border-bottom text-center">{{ $certificate->address }}</td>
            <td style="width: 10%" class="text-center">on</td>
            <td style="width: 40%"
                class="border-bottom text-center">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}</td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 10%">at about</td>
            <td class="border-bottom text-center"
                style="width: 10%">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('h:iA')) }}</td>
            <td class="text-center" style="width: 35%">
                for the following lesion / injury;
            </td>
            <td></td>
        </tr>
    </table>
    <div style="color:white">A</div>
    <div style="color:white">A</div>
    <table style="width: 100%">
        @for($i=0; $i<count($diagnosis); $i++)
            <tr>
                <td style="width: 15%;color:white">sustained by:</td>
                <td>{{ $diagnosis[$i]->diagnosis }}</td>
            </tr>
        @endfor
    </table>
    <div style="color:white">A</div>
    <div style="color:white">A</div>
    <table style="width: 100%">
        <tr>
            <td style="width: 15%">sustained by:</td>
            <td>NOI: {{ $sustained->noi }}</td>
        </tr>
        <tr>
            <td></td>
            <td>DOI: {{ $sustained->doi }}</td>
        </tr>
        <tr>
            <td></td>
            <td>POI: {{ $sustained->poi }}</td>
        </tr>
        <tr>
            <td></td>
            <td>TOI: {{ $sustained->toi }}</td>
        </tr>
    </table>
    <div class="certificate-text">
        <table style="width: 100%">
            <tr>
                <td colspan="3">
                    <div style="margin-left: 20px">In my opinion, the injuries sustained by the patient will
                        incapacitate or require medical
                    </div>
                </td>
            </tr>
            <tr>
                <td>attention for a period of</td>
                <td style="width: 30%" class="border-bottom text-center">
                    {{ $certificate->days_barred }}
                </td>
                <td>day/days barring complications, otherwise</td>
            </tr>
            <tr>
                <td colspan="3">
                    <div style="text-align: left">
                        the period of healing will vary accordingly.
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="doctor-container mt-3">
        <div><u>{{ $certificate->doctor }}</u></div>
        <div>{{ $certificate->doctor_designation }}</div>
        <div>License No.: <span class="ml-1"><u>{{ $certificate->doctor_license }}</u></span></div>
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
                <td>₱{{ number_format($certificate->amount,2) }}</td>
                <td>
                    <small></small>
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
                    <small></small>
                </td>
            </tr>
        </table>
    </div>
    <div class="mt-3" style="float:right">
        <div>MPS - REC - FM - 05</div>
        <div>07-Dec-18</div>
    </div>
</div>
<script>
    // Disable right-click
    // document.addEventListener('contextmenu', event => event.preventDefault());
    // // Disable keyboard shortcuts (F12, Ctrl+Shift+I, etc.)
    // document.onkeydown = function(e) {
    //     if ((e.keyCode === 85 || e.keyCode === 67 || e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 123)) {
    //         e.preventDefault();
    //         return false;
    //     }
    // };
</script>
</body>
</html>
