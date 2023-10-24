<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Verification Results</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .no-record {
            font-size: 18px;
            color: #ff0000;
            margin-top: 20px;
        }

        .container {
            max-width: 600px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .banner img {
            display: block;
            max-width: 100%;
            width: 100%;
            height: auto;
        }

        header {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }

        header h1 {
            margin: 0;
        }

        .record p {
            font-size: 20px;
            text-align: left;
            margin: 5px 0;
        }

        footer {
            padding: 20px;
        }

        .disclaimer {
            font-size: 18px;
            color: #555;
        }

        main {
            padding: 20px;
        }


    </style>
</head>
<body>
<div class="center-container">
    <div class="container">
        <div class="banner">
            <img src="images/banner.jpg" alt="Banner Image">
        </div>
        <main>
            @if($data)
                <div class="record">
                    <p><strong>Patient:</strong> {{ $data->patient }}</p>
                    <p><strong>Health Record No.:</strong> {{ $data->health_record_no }}</p>
                    <p><strong>Certificate No:</strong> {{ $data->certificate_no }}</p>
                    <p><strong>Date
                            Issued:</strong> {{ \Illuminate\Support\Carbon::parse($data->date_issued)->format('F d, Y') }}
                    </p>
                </div>
            @else
                <i class="fas fa-times-circle not-found-icon fa-4x"></i>
                <div class="no-record">No record found</div>
            @endif
        </main>
        <footer>
            <p class="disclaimer">To verify the authenticity of this certificate, please contact Cebu South Medical
                Center - Health Information Management Department (Medical Records Office)
            </p>
            <p class="disclaimer" style="text-align: left;margin-top: 10px;font-size: 14px">
                Telephone Number: (032) 265-5986 local 47<br>
                E-mail address: medicalrecordstdh@gmail.com<br/>
            </p>
        </footer>
    </div>
</div>
</body>
</html>

