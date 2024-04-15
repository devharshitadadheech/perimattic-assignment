<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name') }}::Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
</head>

<body class="body">
    @include('layout.header')
    <div class="form">
        @include('layout.notifications')
        <h2>Login</h2>
        <form action="{{ route('verify') }}" id="loginForm" method="POST">
            @csrf
            <div class="input">
                <div class="inputBox">
                    <label for="">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email">
                </div>
                <div class="inputBox">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password"> 
                </div>
                <div class="inputBox">
                    <input type="submit" name="" value="Log In">
                </div>
            </div>
            <p class="forgot">Not registerd yet? <a href="{{ route('register')}}">Click Here</a></p>
        </form>
    </div>

</body>

</html>