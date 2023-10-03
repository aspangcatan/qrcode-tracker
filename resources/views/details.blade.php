<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Code Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #333;
        }

        .record {
            font-size: 18px;
            margin: 40px 0;
            text-align: left;
        }

        .record div {
            margin-bottom: 5px;
        }

        .record div:last-child {
            margin-bottom: 0;
        }

        .record span {
            margin-left: 10px;
            font-weight: bold;
        }

        .no-record {
            font-size: 18px;
            color: #ff0000;
            margin-top: 20px;
        }

        /* Icon styles */
        .success-icon {
            color: #008000; /* Green color for success */
        }

        .not-found-icon {
            color: #ff0000; /* Red color for not found */
        }

        /* Logo and Disclaimer */
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }

        .logo img {
            width: 40px; /* Adjust the width as needed */
            height: auto;
            margin-right: 20px;
        }

        .disclaimer {
            font-size: 14px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    @if($data)
        <i class="fas fa-check-circle success-icon fa-5x"></i>
        <h1>QR Code Verified</h1>
        <div class="record">
            <div><span>Patient:</span> {{ $data->patient_name }}</div>
            <div><span>Hospital No:</span> {{ $data->hospital_no }}</div>
            <div><span>Certificate No:</span> {{ $data->certificate_no }}</div>
            <div><span>Date Issued:</span> {{ $data->date_issued }}</div>
        </div>
    @else
        <i class="fas fa-times-circle not-found-icon fa-4x"></i>
        <div class="no-record">No record found</div>
@endif

<!-- Logo and Disclaimer -->
    <div class="logo-container">
        <div class="logo">
            <img src="assets/img/logo.png" alt="Company Logo">
        </div>
        <div class="disclaimer">
            This QR code verification service is provided by Cebu South Medical Center.<br>
            All rights reserved.
        </div>
    </div>
</div>
</body>
</html>
