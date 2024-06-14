<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Web API</title>
    <link rel="icon" href="logo_header.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        .top-right {
            position: fixed;
            top: 10px;
            right: 20px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content span, .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {background-color: #f1f1f1;}
        .show {display: block;}
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#" data-page="Customers">Handle Customers</a>
        <a href="#" data-page="Zone">Zone</a>
    </div>

    <div class="content" id="content">
        @yield('dynamic-content')
    </div>

    <div class="top-right">
        <div class="dropdown">
            <i class="fas fa-user-circle fa-2x" onclick="toggleDropdown()"></i>
            <div id="myDropdown" class="dropdown-content">
                <span id="userEmail">{{ Auth::user()->email }}</span>
                <a href="#" onclick="logout()">Log Out</a>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            const links = $('.sidebar a');
            const content = $('#content');

            links.on('click', function(event) {
                event.preventDefault();
                const page = $(this).data('page');
                loadPage(page);
            });

            function loadPage(page) {
                $.ajax({
                    url: `/${page}`,
                    method: 'GET',
                    success: function(response) {
                        content.html(response);
                    },
                    error: function(error) {
                        console.error('Error loading page:', error);
                        content.html('<p>Error loading page content.</p>');
                    }
                });
            }
        });

        function toggleDropdown() {
            $('#myDropdown').toggleClass('show');
        }

        $(window).on('click', function(event) {
            if (!$(event.target).closest('.fa-user-circle').length) {
                $('.dropdown-content').removeClass('show');
            }
        });
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            console.log('Full Cookie String:', value);
            const parts = value.split(`; ${name}=`);
            console.log('Cookie Parts:', parts);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        function logout() {
            const encryptedToken = getCookie('encrypted_token');
            console.log('Encrypted Token:', encryptedToken);
            $.ajax({
                url: '{{ route("logout1") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Authorization': `Bearer ${encryptedToken}`
                },
                success: function(response) {
                    window.location.href = response.redirectUrl;
                },
                error: function() {
                    alert('Logout failed.');
                }
            });
        }
    </script>
</body>
</html>