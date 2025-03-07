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
            justify-content: flex-end; /* Aligns it to the right */
            margin-top: 70px;
            width: 100%; /* Ensures it spans the full width so it has room */
        }

        .doctor-container table {
            width: auto; /* Table only takes the space it needs */
            text-align: center;
            white-space: nowrap; /* Ensures the content does not wrap to new lines */
        }

        .doctor-container td {
            padding: 0 5px; /* Add a bit of spacing between the columns */
        }

        .doctor-container u {
            font-weight: bold;
            display: inline-block;
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
        DENTAL CERTIFICATE
    </div>
    <div class="certificate-text">
        <table style="width: 100%" class="word-spacing">
            <tr>
                <td style="width: 25%">
                    <p>This is to certify that</p>
                </td>
                <td class="border-bottom text-center fw-bold" style="width: 35%">
                    {{ $certificate->patient }}
                </td>
                <td>,</td>
                <td class="border-bottom text-center fw-bold" style="width: 25%">
                    {{ $certificate->age }}
                </td>
                <td>
                    <p>, of</p>
                </td>
            </tr>
            <tr class="text-center no-spacing">
                <td></td>
                <td>
                    <small>Name of requesting patient</small>
                </td>
                <td></td>
                <td>
                    <small>Age</small>
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td class="border-bottom text-center fw-bold" style="width:60%">
                    {{ $certificate->address }}
                </td>
                <td>
                    <p style="margin-left: 10px">was examined and treated in this</p>
                </td>
            </tr>
            <tr class="text-center no-spacing">
                <td>
                    <small>Address</small>
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td style="width: 22%">
                    <p>hospital on/from</p>
                </td>
                <td class="border-bottom text-center fw-bold">
                    {{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}
                </td>
                <td style="width: 50%;">
                    <p style="margin-left: 10px">with the following findings and/or diagnosis:</p>
                </td>
            </tr>
            <tr class="text-center no-spacing">
                <td></td>
                <td>
                    <small>Date</small>
                </td>
            </tr>
        </table>
    </div>

    <div class="certificate-diagnosis"
         style="margin-left: 130px;margin-top:{{$d_margin_top}}px;margin-bottom:{{$d_margin_bottom}}px;text-transform: uppercase">
        @for($i=0; $i<count($diagnosis); $i++)
            <div>{!! $diagnosis[$i]->diagnosis !!}</div>
        @endfor
    </div>

    <div class="certificate-text">
        <table style="width: 100%">
            <tr>
                <td style="width: 60%">
                    <p>This certification is being issued at the request of</p>
                </td>
                <td class="border-bottom text-center fw-bold">
                    <div class="ml-1">{{ $certificate->requesting_person }}</div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td class="text-center">
                    <small>Name of Person Requesting</small>
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td style="width: 1%">for</td>
                <td class="border-bottom fw-bold text-center" style="width: 65%">
                    <div class="ml-1">{{ $certificate->purpose }}</div>
                </td>
                <td style="width: 35%"></td>
            </tr>
            <tr>
                <td></td>
                <td class="text-center">
                    <small>Purpose</small>
                </td>
            </tr>
        </table>
    </div>
    <div class="doctor-container mt-5">
        <table>
            <tr>
                <td style="width: 40%"></td>
                <td style="width: 50%">
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
                    @if($certificate->doctor_license)
                        License No.: <span class="ml-1"><u>{{ $certificate->doctor_license }}</u></span>
                    @endif
                </td>
                <td></td>
            </tr>
        </table>
    </div>
    <div style="clear: both"></div>
    <div style="margin-top:{{$seal_margin_top}}px">
        <div class="fw-bold">(NOT VALID WITHOUT SEAL)</div>
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
