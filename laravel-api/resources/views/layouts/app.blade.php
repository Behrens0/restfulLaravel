<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Web API</title>
    <link rel="icon" href="logo_header.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            height: 100%;
            background-color: #333;
            color: #fff;
            padding-top: 50px;
            overflow-y: auto;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #555;
            color: #fff;
        }
        .content {
            margin-left: 200px;
            padding: 20px;
            width: calc(100% - 200px);
            overflow-y: auto;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#" data-page="Customers">Handle Customers</a>
        <a href="#" data-page="Zone">Zone</a>
    </div>

    <div class="content" id="content">
        <!-- Dynamic content will be loaded here -->
        @yield('dynamic-content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.sidebar a');
            const content = document.getElementById('content');

            links.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const page = this.getAttribute('data-page');
                    loadPage(page);
                });
            });

            function loadPage(page) {
                fetch(`/${page}`)
                    .then(response => response.text())
                    .then(html => {
                        content.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading page:', error);
                        content.innerHTML = '<p>Error loading page content.</p>';
                    });
            }
        });
    </script>
</body>
</html>