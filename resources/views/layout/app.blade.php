<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @include('layout.header')
</head>

<body>
    <main class="app">
        @include('layout.navbar')
        <div class="content">
            @include('layout.notifications')
            <div class="container-fluid">
                <h4 class="mb-5">@yield('heading')</h4>
                @yield('content')
            </div>
        </div>
    </main>
    @extends('layout.footer')
</body>

</html>
