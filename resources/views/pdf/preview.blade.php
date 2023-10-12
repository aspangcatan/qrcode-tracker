<!DOCTYPE html>
<html>
<head>
    <title>PDF Preview</title>
    <style>
        /* Add any custom CSS styling for the PDF preview here */
        body {
            margin: 0;
            padding: 0;
        }
        /* Adjust styles as needed for your layout */
    </style>
</head>
<body>
<!-- You can customize the PDF preview layout here -->
<div style="width: 100%; height: 100vh; overflow: hidden;">
    <iframe src="data:application/pdf;base64,{{ base64_encode($pdf->output()) }}" width="100%" height="100%" frameborder="0"></iframe>
</div>
</body>
</html>
