<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Other Polls</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (can reuse or create new if needed) -->
    <link rel="stylesheet" href="{{ asset('css/polls.css') }}">
</head>
<body>
    <div class="container mt-4">
        <h1>Other Polls</h1>

        <!-- Public poll list will be loaded here by JavaScript -->
        <div id="public-polls-list">
            Loading public polls...
        </div>

    </div>

    <!-- Bootstrap 5 JS CDN (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ secure_asset('js/public_polls.js') }}"></script>
</body>
</html> 