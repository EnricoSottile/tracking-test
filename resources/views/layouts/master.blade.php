<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>What.digital @yield('page_title')</title>

    <!-- development only -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        button[disabled] {
            background-color: grey !important;
            cursor:not-allowed;
            pointer-events: none;
        }
    </style>

</head>

<body>
    <div class="container mx-auto px-4 my-4">
        @yield('main_content')
    </div>
</body>

</html>
