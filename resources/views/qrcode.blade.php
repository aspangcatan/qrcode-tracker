<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>QR Code Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <style>
        /* Custom styles */
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            display: flex; /* Use flexbox to align card elements */
        }

        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            flex: 1; /* Share available space equally */
        }

        #qrCode {
            margin-bottom: 20px;
        }

        #downloadLink {
            margin-top: 20px;
        }

        .patient-info {
            padding: 20px;
            flex: 1; /* Share available space equally */
        }

        .patient-info h4 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        .patient-info ul {
            list-style: none;
            padding: 0;
        }

        .patient-info li {
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>QR Code Generator</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div id="qrCode">
                        {!! QrCode::size(200)->generate($qrcode->url) !!}
                    </div>
                    <a id="downloadLink" href="#" class="btn btn-primary btn-block">Download QR Code</a>
                </div>
                <div class="col-md-9">
                    <div class="patient-info">
                        <h4>Patient Information</h4>
                        <ul>
                            <li><strong>Patient:</strong> {{ $qrcode->patient_name }}</li>
                            <li><strong>Hospital No:</strong> {{ $qrcode->hospital_no }}</li>
                            <li><strong>Certificate No:</strong> {{ $qrcode->certificate_no }}</li>
                            <li><strong>Date Issued:</strong> {{ $qrcode->date_issued }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#downloadLink').click(function() {
            // Get the SVG element containing the QR code
            var svgElement = document.querySelector('svg');

            // Convert the SVG to a data URL
            var svgData = new XMLSerializer().serializeToString(svgElement);
            var dataUri = 'data:image/svg+xml;base64,' + btoa(svgData);

            // Create an invisible anchor element
            var downloadAnchor = document.createElement('a');
            downloadAnchor.href = dataUri;
            downloadAnchor.download = 'qr_code.svg'; // Specify the download file name

            // Trigger a click event on the anchor element to start the download
            downloadAnchor.click();
        });
    });
</script>

</body>
</html>
