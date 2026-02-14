<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Home' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
</head>
<body>

<header class="bg-dark">
    <div class="container">
        <nav class="navbar navbar-expand-xl">
            <a href="{{ url('/') }}" class="text-decoration-none">
                <span class="h2 text-primary">Online</span>
                <span class="h2 text-white">SHOP</span>
            </a>
        </nav>
    </div>
</header>
