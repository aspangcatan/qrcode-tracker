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
    <table style="width: 100%;margin-top:15px">
        <tr>
            <td style="width: 27%">
                <p>This is to certify that</p>
            </td>
            <td class="border-bottom text-center fw-bold" style="width: 50%">
                {{ $certificate->patient }}
            </td>
            <td>,</td>
            <td style="width: 30%" class="border-bottom text-center fw-bold">{{ $certificate->age }} </td>
            <td>,</td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td>
                <small>Name of requesting</small>
            </td>
            <td></td>
            <td>
                <small>Age</small>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td colspan="4">
                <div style="word-spacing: 8px;">
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
                    @endif, <strong>Filipino</strong>, and a resident of
                </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 45%" class="border-bottom text-center fw-bold">{{ $certificate->address }}</td>
            <td style="width: 10%" class="text-center">on</td>
            <td style="width: 40%"
                class="border-bottom text-center fw-bold">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('F j, Y')) }}</td>
        </tr>
        <tr class="text-center">
            <td>
                <small>Address</small>
            </td>
            <td></td>
            <td>
                <small>Date</small>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 10%">at about</td>
            <td class="border-bottom text-center fw-bold"
                style="width: 20%">{{ strtoupper(\Illuminate\Support\Carbon::parse($certificate->date_examined)->format('h:iA')) }}</td>
            <td style="width: 70%;">
                for the following lesion / injury;
            </td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td>
                <small>Time</small>
            </td>
        </tr>
    </table>

    <table style="width: 100%;margin-top:{{$d_margin_top}}px;margin-bottom:{{$d_margin_bottom}}px;text-transform: uppercase">
        @for($i=0; $i<count($diagnosis); $i++)
            <tr>
                <td style="width: 15%"></td>
                <td>{!! $diagnosis[$i]->diagnosis !!}</td>
            </tr>
        @endfor
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 15%">sustained by:</td>
            <td>NOI:
                @if($sustained)
                    {{ $sustained->noi }}
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                DOI:
                @isset($sustained->doi)
                    @php
                        try {
                            echo \Carbon\Carbon::parse($sustained->doi)->format('m/d/Y');
                        } catch (\Exception $e) {
                            echo $sustained->doi;
                        }
                    @endphp
                @endisset
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                TOI:
                @isset($sustained->toi)
                    @php
                        try {
                            echo \Carbon\Carbon::parse($sustained->toi)->format('h:i A');
                        } catch (\Exception $e) {
                            echo $sustained->toi;
                        }
                    @endphp
                @endisset
            </td>
        </tr>
        <tr>
            <td></td>
            <td>POI:
                @if($sustained)
                    {{ $sustained->poi }}
                @endif
            </td>
        </tr>

    </table>
    <div class="certificate-text">
        <table style="width: 100%">
            <tr>
                <td colspan="3">
                    <div>In my opinion, the injuries sustained by the patient will
                        incapacitate or require medical
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 25%">attention for a period of</td>
                <td style="width: 30%" class="border-bottom text-center">
                    {{ $certificate->days_barred }}
                </td>
                <td>day/days barring complications.</td>
            </tr>
            <tr>
                <td colspan="3">
                    <div>
                        Otherwise, the period of healing will vary accordingly.
                    </div>
                </td>
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
                <td>₱150.00</td>
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
        <div>MPS - REC - FM - 05</div>
        <div>07-Dec-18</div>
    </div>
</div>
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.onkeydown = function (e) {
        if ((e.keyCode === 85 || e.keyCode === 67 || e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 123)) {
            e.preventDefault();
            return false;
        }
    };
</script>
</body>
</html>
