<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="admin-login">
        <form class="form">
            <div class="form__header">
                Log in
            </div>
            <div class="form__inputs">
                <label class="form__input__label">
                    <div class="form__input__description">Email address</div>
                    <input type="text" class="form__input" placeholder="you@example.com">
                </label>

                <label class="form__input__label">
                    <div class="form__input__description">Password</div>
                    <input type="text" class="form__input" placeholder="Enter your password">
                </label>
            </div>

            <button class="form__button">
                Log In
            </button>
        </form>
    </div>
</body>
</html>