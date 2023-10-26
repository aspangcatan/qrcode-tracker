<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>QR Tracker</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
{{--    <link href="https://fonts.gstatic.com" rel="preconnect">--}}
{{--    <link--}}
{{--        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"--}}
{{--        rel="stylesheet">--}}

<!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css?v={{ date('ymdhis') }}" rel="stylesheet">
    <link href="css/toastr.min.css?v={{ date('ymdhis') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- =======================================================
    * Template Name: NiceAdmin - v2.5.0
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
    <style>
        .tooltip {
            position: relative;
            display: inline-block;
            border: 1px solid #333;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        /* Style the tooltip text */
        .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.2s;
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
            margin-top: 20px;
            margin-left: 20%;
            margin-right: 10%;
        }

        .certificate-text > div {
            margin-top: 20px;
        }

        .is-invalid {
            border: 1px solid #dc3545; /* Red border color */
            background-color: #f8d7da; /* Red background color */
            color: #dc3545; /* Red text color */
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

        .very-small {
            text-align: center;
            width: 60px; /* Adjust the width as needed */
            border-bottom: 1px solid black;
            display: inline-block;
        }


        .small {
            text-align: center;
            width: 180px; /* Adjust the width as needed */
            border-bottom: 1px solid black;
            display: inline-block;
        }

        .very-small input {
            text-align: center;
            width: 100%;
            border: 0px solid transparent;
        }

        .small input {
            text-align: center;
            width: 100%;
            border: 0px solid transparent;
        }

        .btn-transparent {
            background: transparent;
            border: 0px solid transparent;
        }

        .medium input {
            text-align: center;
            width: 100%;
            border: 0px solid transparent;
        }

        .long input {
            text-align: center;
            width: 100%;
            border: 0px solid transparent;
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
            justify-content: center;
            align-items: end;
        }

        .mt-3 {
            margin-top: 30px;
        }

        .text-center {
            text-align: center;
        }

    /*
    */


    </style>
</head>

<body>
<div class="fullscreen-modal d-none" id="spinner">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <div class="text-white fs-5 mt-1">Loading, please wait ...</div>
</div>
<!-- ======= Header ======= -->
@include('layouts.navbar')
@include('modals.settings')
<!-- ======= Sidebar ======= -->
<main id="main" class="main">
    <div class="pagetitle">
        <h1>@yield('Title')</h1>
    </div>
    <section class="section dashboard">
        @yield('content')
    </section>

</main>
<!-- End #main -->
<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/toastr.min.js"></script>
<script src="js/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    const settings_modal = new bootstrap.Modal(document.getElementById('settings_modal'));

    $(document).ready(function () {
        toastr.options = {
            "positionClass": "toast-bottom-right",
        }

        $("#change_password").click(function (e) {
            e.preventDefault();
            settings_modal.toggle();
        });

        $("#btn_change_password").click(function () {
            let is_valid = true;
            $("#settings_modal .is-invalid").removeClass("is-invalid");
            $("#settings_modal .error_container").addClass("d-none");
            $("#settings_modal .error_list").empty();

            const old_password = $("#old_password").val().trim();
            const new_password = $("#new_password").val().trim();
            const confirm_password = $("#confirm_password").val().trim();

            if (old_password == "") {
                is_valid = false;
                $("#settings_modal .error_list").append("<li>Old password is required</li>");
                $("#old_password").addClass("is-invalid");
            }

            if (new_password == "") {
                is_valid = false;
                $("#settings_modal .error_list").append("<li>New password is required</li>");
                $("#old_password").addClass("is-invalid");
            }

            if (confirm_password == "") {
                is_valid = false;
                $("#settings_modal .error_list").append("<li>Confirm password is required</li>");
                $("#old_password").addClass("is-invalid");
            }

            if (new_password.length < 4) {
                is_valid = false;
                $("#settings_modal .error_list").append("<li>New password must at least 4 characters</li>");
                $("#new_password").addClass("is-invalid");
            }

            if (new_password != confirm_password) {
                is_valid = false;
                $("#settings_modal .error_list").append("<li>Password mismatch</li>");
                $("#new_password").addClass("is-invalid");
            }

            if (!is_valid) {
                $("#settings_modal .error_container").removeClass("d-none");
                return;
            }

            const params = {
                old_password: old_password,
                new_password: new_password,
                confirm_password: confirm_password
            }

            fetch('{{route('changePassword')}}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(params)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.code == 500) {
                        toastr.error(data.message, "Something went wrong")
                        return;
                    }

                    settings_modal.toggle();
                    toastr.success(data.message, "Information");
                    $("#old_password").val("");
                    $("#new_password").val("");
                    $("#confirm_password").val("");
                }).catch(err => {
                alert(err);
            });
        });
    });
</script>
@yield('js')
</body>

</html>
