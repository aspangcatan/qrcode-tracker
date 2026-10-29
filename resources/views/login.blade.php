<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CSMC QR Tracker: medical certificate issuance, queueing and QR verification of Cebu South Medical Center.">
    <title>Sign in · CSMC QR Tracker</title>
    <link rel="icon" href="{{ asset('images/csmc-logo.png') }}" type="image/png">

    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>

<header class="topbar">
    <div class="brand">
        <img src="{{ asset('images/csmc-logo.png') }}" alt="Cebu South Medical Center logo">
        <div>
            <span class="brand-org">Cebu South Medical Center</span>
            <span class="brand-name">QR Tracker</span>
        </div>
    </div>
    <span class="topbar-note"><i class="bi bi-building"></i> Health Information Management Department</span>
</header>

<main class="stage">
    <div class="card">
        <section class="auth">
            <div>
                <p class="eyebrow">Medical Records Office</p>
                <h1>Welcome back</h1>
                <p class="muted">Sign in with your hospital username and password.</p>
            </div>

            @if(Session::has('message'))
                <p class="alert" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ Session::get('message') }}
                </p>
            @endif

            <form method="post" action="{{ route('authenticate') }}" id="login-form">
                @csrf
                <div class="field">
                    <label for="username">Username</label>
                    <div class="input-wrap">
                        <i class="bi bi-person"></i>
                        <input type="text" id="username" name="username" autocomplete="username"
                               placeholder="Enter your username" required autofocus>
                    </div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="password" name="password" autocomplete="current-password"
                               placeholder="Enter your password" required>
                        <button type="button" class="reveal" id="toggle-password"
                                aria-label="Show password" aria-pressed="false">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-primary">
                    <span>Sign in</span> <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <p class="help">
                <i class="bi bi-info-circle"></i>
                <span>Trouble signing in? Contact the System Administrator.</span>
            </p>
        </section>

        <aside class="showcase" aria-hidden="true">
            <div class="scanner">
                <span class="corners"></span>
                <span class="code"><i class="bi bi-qr-code"></i></span>
                <span class="beam"></span>
            </div>
            <div>
                <h2>Every certificate, <span>verifiable by QR.</span></h2>
                <p class="showcase-text">
                    Certificates issued here carry a QR code that links back to the record on file.
                </p>
            </div>
            <ul class="flow">
                <li><i class="bi bi-ticket-perforated"></i> Queue</li>
                <li><i class="bi bi-file-earmark-medical"></i> Issue</li>
                <li><i class="bi bi-patch-check"></i> Verify</li>
            </ul>
        </aside>
    </div>
</main>

<p class="footnote">&copy; {{ date('Y') }} Cebu South Medical Center · QR Tracker</p>

<script>
    (function () {
        var password = document.getElementById('password');
        var toggle = document.getElementById('toggle-password');

        toggle.addEventListener('click', function () {
            var show = password.type === 'password';
            password.type = show ? 'text' : 'password';
            toggle.setAttribute('aria-pressed', show);
            toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            toggle.querySelector('i').className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });

        document.getElementById('login-form').addEventListener('submit', function () {
            var button = this.querySelector('button[type=submit]');
            button.disabled = true;
            button.querySelector('span').textContent = 'Signing in…';
        });
    })();
</script>
</body>
</html>
