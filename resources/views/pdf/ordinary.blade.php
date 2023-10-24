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

        .mt-5 {
            margin-top: 70px
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
        MEDICAL CERTIFICATE
    </div>
    <div class="certificate-text">
        <div>
            This is to certify
            <div class="medium">{{ $certificate->patient }}</div>
            ,
            <div class="small">{{ $certificate->age }}</div>
            , of
        </div>
        <div>
            <div class="long">{{ $certificate->address }}</div>
            was examined and treated in this<br/>
        </div>
        <div>
            hospital on/from
            <div
                class="small">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}</div>
            with the following findings and/or diagnosis:
        </div>
    </div>
    <div style="color:white">A</div>
    <div style="color:white">A</div>
    <div class="certificate-diagnosis" style="margin-left: 35%">
        @for($i=0; $i<count($diagnosis); $i++)
            <div>{!! $diagnosis[$i]->diagnosis !!}</div>
        @endfor
    </div>
    <div style="color:white">A</div>
    <div style="color:white">A</div>
    <div class="certificate-text">
        <table style="width: 100%">
            <tr>
                <td style="width: 60%">This certification is being issued at the requested of</td>
                <td>
                    <div class="border-bottom ml-1">{{ $certificate->requesting_person }}</div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <small>Name of Person Requesting</small>
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td style="width: 10%">for</td>
                <td style="width: 65%">
                    <div class="border-bottom ml-1">{{ $certificate->purpose }}</div>
                </td>
                <td style="width: 20%"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <small>Purpose</small>
                </td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="doctor-container mt-5">
        @if(strlen($certificate->doctor) >= 20)
            <div style="font-size: 12px">
                @else
                    <div>
                        @endif
                        <div><u>{{ $certificate->doctor }}</u></div>
                        <div>{{ $certificate->doctor_designation }}</div>
                        <div>License No.: <span class="ml-1"><u>{{ $certificate->doctor_license }}</u></span></div>
                    </div>
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
