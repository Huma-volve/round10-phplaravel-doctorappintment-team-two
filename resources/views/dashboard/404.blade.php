<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Not Found</title>
    <!-- Stylesheets -->
    <link rel="shortcut icon" href="{{ asset('dashboard-assets/images/favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('dashboard-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/icons/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/icons/fontawesome/css/brands.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/icons/fontawesome/css/solid.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/plugin/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/css/style.css') }}" rel="stylesheet">
</head>
<body>

    <div class="error-page">
        <div class="text-center">
            <div class="error-code">404</div>
            <h1 class="error-title">
                <i class="fa-solid fa-thumbs-down error-icon"></i>
                Page Not Found
            </h1>
            <p class="error-message">The page you are looking for does not exist or has been moved.</p>
            <a href="{{ route('dashboard.index') }}" class="btn btn-primary back-home">Back to Home</a>
        </div>
    </div>

     <!-- Scripts -->
    <script  src="{{ asset('dashboard-assets/js/jquery-3.6.0.min.js') }}"></script>
    <script  src="{{ asset('dashboard-assets/js/bootstrap.bundle.min.js') }}"></script>
    <script  src="{{ asset('dashboard-assets/plugin/chart/chart.js') }}"></script>
    <script  src="{{ asset('dashboard-assets/plugin/quill/quill.js') }}"></script>
    <script  src="{{ asset('dashboard-assets/js/chart.js') }}"></script>
    <script  src="{{ asset('dashboard-assets/js/main.js') }}"></script>
</body>
</html>