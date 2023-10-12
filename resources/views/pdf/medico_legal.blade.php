<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

        body {
            padding: 0 !important;
            margin: 0 !important;
            font-size: 16px;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 160px;
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
            <td></td>
            <td>
                <div class="certificate-details">
                    {!! QrCode::size(50)->generate("https://hellow") !!}
                    <div class="mt-1">
                        Certificate No:
                        <div class="small">1234</div>
                    </div>
                    <div>
                        Health Record No:
                        <div class="small">67890</div>
                    </div>
                    <div class="mt-1">
                        Date:
                        <div class="small">OCTOBER 10, 2023</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="certificate-title">
        MEDICO LEGAL CERTIFICATE
    </div>
    <table style="width: 100%;margin-top:15px">
        <tr>
            <td style="width: 30%"><div style="margin-left: 10px">This is to certify that</div></td>
            <td class="border-bottom text-center" style="width: 50%">
                JUAN DELA CRUZ
            </td>
            <td style="width: 20%">, 30 years old</td>
        </tr>
        <tr>
            <td colspan="4">
                <div style="word-spacing: 10px;">
                    male  /  female,  single  /  married  /  child  /  widow/er, Filipino, and a resident of
                </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 45%" class="border-bottom text-center">SAN ISIDRO, TALISAY CITY, CEBU</td>
            <td style="width: 10%" class="text-center">on</td>
            <td style="width: 40%" class="border-bottom text-center">OCTOBER 20, 2023</td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 10%">at about</td>
            <td class="border-bottom text-center" style="width: 10%">8:10AM</td>
            <td class="text-center" style="width: 35%">
                for the following lesion / injury;
            </td>
            <td></td>
        </tr>
    </table>
    <div style="margin-left: 35%;margin-top: 10px">
        @for($i=0; $i<5; $i++)
            <div>Line {{ $i }} diagnosis</div>
        @endfor
    </div>
    <table style="margin-top: 20px">
        <tr>
            <td style="width: 40%">sustained by:</td>
            <td>NOI: ALLEGED ASSAULT</td>
        </tr>
        <tr>
            <td></td>
            <td>DOI: OCTOBER 08, 2023</td>
        </tr>
        <tr>
            <td></td>
            <td>POI: SAN ISIDRO, TALISAY CITY, CEBU</td>
        </tr>
        <tr>
            <td></td>
            <td>TOI: 7:00 PM</td>
        </tr>
    </table>
    <div class="certificate-text">
        <table style="width: 100%">
            <tr>
                <td colspan="3">
                    <div style="margin-left: 20px">In my opinion, the injuries sustained by the patient will incapacitate or require medical</div>
                </td>
            </tr>
            <tr>
                <td>attention for a period of</td>
                <td style="width: 30%" class="border-bottom text-center">
                    28
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
        <div><u>DR. JAMES C. BERNAL</u></div>
        <div>MEDICAL OFFICER</div>
        <div>License No.: <span class="ml-1"><u>14219</u></span></div>
    </div>

    <div class="mt-3">
        <div>(NOT VALID WITHOUT SEAL)</div>
        <table style="width: 100%">
            <tr>
                <td style="width: 18%">OR NO</td>
                <td style="width: 3%">:</td>
                <td style="width: 49%">123123123</td>
                <td style="width: 30%"></td>
            </tr>
            <tr>
                <td>AMOUNT</td>
                <td>:</td>
                <td>P50.00</td>
                <td>
                    <small>MPS-REC-FM-06</small>
                </td>
            </tr>
            <tr>
                <td>Prepared by</td>
                <td>:</td>
                <td>John Doe</td>
                <td>
                    <small>07-Dec-18</small>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
