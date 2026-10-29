<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate verification · CSMC</title>
    <link rel="icon" href="{{ asset('images/csmc-logo.png') }}" type="image/png">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <style>
        /* Public QR verification page. Colours and type follow the sign-in page (css/login.css). */
        :root {
            --primary: #00236f;
            --primary-container: #1e3a8a;
            --primary-fixed: #dce1ff;
            --secondary: #006a61;
            --secondary-container: #86f2e4;
            --on-secondary-container: #00504a;
            --danger: #ba1a1a;
            --danger-container: #ffdad6;
            --on-danger-container: #93000a;
            --background: #f5f6fc;
            --surface: #ffffff;
            --surface-low: #f2f3ff;
            --on-surface: #131b2e;
            --on-surface-variant: #444651;
            --outline: #757682;
            --line: #e6e8f2;
            --font-body: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            --font-head: 'Plus Jakarta Sans', var(--font-body);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: var(--font-body);
            font-size: 0.9375rem;
            line-height: 1.5;
            color: var(--on-surface);
            background:
                radial-gradient(40rem 24rem at 100% 0%, #eaedff, transparent 70%),
                var(--background);
            -webkit-font-smoothing: antialiased;
        }

        p, h1 { margin: 0; }

        .page {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.25rem;
            max-width: 34rem;
            margin: 0 auto;
            padding: 2.5rem 1rem 3rem;
        }

        .brand { display: flex; align-items: center; gap: 0.75rem; align-self: flex-start; }

        .brand img { width: 2.75rem; height: 2.75rem; object-fit: contain; }

        .brand-org {
            display: block;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--secondary);
        }

        .brand-name { font: 600 0.9375rem/1.25rem var(--font-head); color: var(--primary); }

        .card {
            width: 100%;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 1rem;
            background: var(--surface);
            box-shadow: 0 16px 40px -20px rgba(19, 27, 46, 0.25);
        }

        .status {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            color: #fff;
            background:
                radial-gradient(20rem 12rem at 110% -20%, rgba(134, 242, 228, 0.3), transparent 60%),
                linear-gradient(150deg, var(--primary-container), var(--primary));
        }

        .status.not-found { background: var(--danger-container); color: var(--on-danger-container); }

        .status-icon {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 999px;
            font-size: 1.625rem;
            background: var(--secondary-container);
            color: var(--on-secondary-container);
        }

        .not-found .status-icon { background: #fff; color: var(--danger); }

        .status h1 { font: 700 1.25rem/1.75rem var(--font-head); }

        .status p { font-size: 0.875rem; opacity: 0.85; }

        .record { margin: 0; padding: 0.5rem 1.5rem 1rem; }

        .record div {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
            padding: 0.875rem 0;
            border-bottom: 1px solid var(--line);
        }

        .record div:last-child { border-bottom: 0; }

        .record dt {
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--outline);
        }

        .record dd { margin: 0; font-weight: 600; font-size: 1rem; }

        .record .patient { font: 700 1.125rem/1.5rem var(--font-head); color: var(--primary); }

        .contact { padding: 1.25rem 1.5rem 1.5rem; background: var(--surface-low); border-top: 1px solid var(--line); }

        .contact p { color: var(--on-surface-variant); font-size: 0.875rem; }

        .contact ul { margin: 0.75rem 0 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 0.375rem; }

        .contact li { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; }

        .contact li i { color: var(--secondary); }

        .contact a { color: var(--primary); }

        .footnote { font-size: 0.75rem; color: var(--outline); }
    </style>
</head>
<body>
<div class="page">
    <div class="brand">
        <img src="{{ asset('images/csmc-logo.png') }}" alt="Cebu South Medical Center logo">
        <div>
            <span class="brand-org">Cebu South Medical Center</span>
            <span class="brand-name">Certificate verification</span>
        </div>
    </div>

    <div class="card">
        @if($data)
            <div class="status">
                <span class="status-icon"><i class="bi bi-patch-check-fill"></i></span>
                <div>
                    <h1>Record found</h1>
                    <p>This certificate is on file at CSMC Medical Records.</p>
                </div>
            </div>
            <dl class="record">
                <div>
                    <dt>Patient</dt>
                    <dd class="patient">{{ $data->patient }}</dd>
                </div>
                <div>
                    <dt>Health Record No.</dt>
                    <dd>{{ $data->health_record_no }}</dd>
                </div>
                <div>
                    <dt>Certificate No.</dt>
                    <dd>{{ $data->certificate_no }}</dd>
                </div>
                <div>
                    <dt>Date requested</dt>
                    <dd>{{ \Illuminate\Support\Carbon::parse($data->date_issued)->format('F d, Y') }}</dd>
                </div>
            </dl>
        @else
            <div class="status not-found">
                <span class="status-icon"><i class="bi bi-x-lg"></i></span>
                <div>
                    <h1>No record found</h1>
                    <p>We could not find a certificate for this QR code.</p>
                </div>
            </div>
        @endif

        <div class="contact">
            <p>
                To verify the authenticity of this certificate, please contact Cebu South Medical Center –
                Health Information Management Department (Medical Records Office).
            </p>
            <ul>
                <li><i class="bi bi-telephone"></i> (032) 265-5986 local 147</li>
                <li><i class="bi bi-envelope"></i> <a href="mailto:himd@csmc.doh.gov.ph">himd@csmc.doh.gov.ph</a></li>
            </ul>
        </div>
    </div>

    <p class="footnote">&copy; {{ date('Y') }} Cebu South Medical Center · QR Tracker</p>
</div>
</body>
</html>
