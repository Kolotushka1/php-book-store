<!DOCTYPE html>
<html lang="кг">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/authorization.css') }}">
</head>
<body>
<!-- HEADER -->
@include('includes.header')
<!-- AUTHORIZATION FORM -->
<div class="container-fluid">
    <div class="row justify-content-xl-center">
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col-4">
            <div class="authorization-form-main rounded-5 mt-4 ps-4 pe-4">
                <p class="fs-4 pt-4 pb-4"><strong>Вход</strong></p>
                <div class="form-to-authorize">
                    <form action="{{ route('authorization') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control shadow-none form-to-authorize-input" name="email" id="email" placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control shadow-none form-to-authorize-input" name="password" id="password">
                        </div>
                        <button class="btn" id="form-to-authorize-button" type="submit">Вход</button>
                    </form>
                    <a class="forgetPassword" href="#">Забыли пароль?</a>
                    <div class="enter-by-another">
                        <p><strong>Или воойдите с помощью других сервисов</strong></p>
                        <a href="#"><img src="{{asset('images/styles/vk_black.svg')}}"></a>
                        <a href="#"><img src="{{asset('images/styles/instagram_black.svg')}}"></a>
                        <a href="#"><img src="{{asset('images/styles/twitter_black.svg')}}"></a>
                    </div>
                </div>
            </div>
            <div class="still-do-not-have-account rounded-4 mt-4 text-center fs-5 pt-4 pb-4 justify-content-center">
                <p>Ещё нет аккаунта?<a href="/register"> Зарегестрируйтесь</a></p>
            </div>
        </div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
    </div>
</div>
<!-- FOOTER -->
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
