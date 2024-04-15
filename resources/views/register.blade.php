<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name') }}::Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
</head>

<body class="body">
    @include('layout.header')
    <div class="form">
        <h2>Login</h2>
        @include('layout.notifications')
        <form action="{{ route('user.create') }}" id="registerForm" method="POST">
            @csrf
            <div class="input">
                <div class="inputBox">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" placeholder="Name">
                </div>
                <div class="inputBox">
                    <label for="">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email">
                </div>
                <div class="inputBox">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                <div class="inputBox">
                    <label for="">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                </div>
                <div class="inputBox">
                    <input type="submit" name="" value="Sign In">
                </div>
            </div>
            <p class="forgot">Already User? <a href="{{ route('login')}}">Click Here</a></p>
        </form>
    </div>

</body>

</html>