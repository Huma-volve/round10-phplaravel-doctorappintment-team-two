<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Error</title>
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
            <div class="error-code">500</div>
            <h1 class="error-title">
                <i class="fa-solid fa-triangle-exclamation error-icon text-danger"></i>
                Server Error
            </h1>
            <p class="error-message">Something went wrong on our end. Please try again later.</p>
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