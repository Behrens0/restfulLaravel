<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Include CSS, JavaScript, or other assets here -->
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <!-- Include JavaScript or other scripts here -->
</body>
</html>