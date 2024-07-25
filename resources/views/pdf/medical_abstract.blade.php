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
        MEDICAL ABSTRACT
    </div>
    <table style="width: 100%">
        <tr>
            <td style="width: 15%">
                Name:
            </td>
            <td style="width: 40%">
                <div>
                    <div style="width: 95%" class="small fw-bold">{{ $certificate->patient }}</div>
                </div>
            </td>
            <td style="width: 5%;text-align: right">
                Age:
            </td>
            <td>
                <div>
                    <div style="width: 100%" class="small fw-bold">{{ $certificate->age }}</div>
                </div>
            </td>
            <td style="width: 5%">
                Sex:
            </td>
            <td>
                <div>
                    <div style="width: 100%" class="small fw-bold">{{ $certificate->sex }}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>Address:</td>
            <td>
                <div>
                    <div style="width: 95%" class="small fw-bold">{{ $certificate->address }}</div>
                </div>
            </td>
            <td>Ward/Room:</td>
            <td colspan="3">
                <div>
                    <div style="width: 100%" class="small fw-bold">{{ $certificate->ward }}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>Date Admitted:</td>
            <td>
                <div>
                    <div style="width: 95%" class="small fw-bold">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}</div>
                </div>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 30px">
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
                <td style="text-align: right">
                    <small>MPS-REC-FM-04</small>
                </td>
            </tr>
            <tr>
                <td>Prepared by</td>
                <td>:</td>
                <td>
                    {{ $certificate->prepared_by }}
                </td>
                <td style="text-align: right">
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
