<!DOCTYPE html>
<html lang="кг">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/register.css') }}">
</head>
<body>
<!-- HEADER -->
@include('includes.header')
<!-- REGISTRATION FORM -->
<div class="container-fluid">
    <div class="row justify-content-xl-center">
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col-4">
            <div class="authorization-form-main rounded-5 mt-4 ps-4 pe-4">
                <p class="fs-4 pt-3"><strong>Регистрация</strong></p>
                <div class="form-to-authorize">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for=email" class="form-label">Email</label>
                            <input type="email" class="form-control shadow-none form-to-authorize-input" name="email" id="email" placeholder="name@example.com" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="fio" class="form-label">ФИО</label>
                            <input type="text" class="form-control shadow-none form-to-authorize-input" name="fio" id="fio" required>
                            @error('fio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Номер телефона</label>
                            <input type="text" class="form-control shadow-none form-to-authorize-input" name="phone" id="phone" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Адрес</label>
                            <input type="text" class="form-control shadow-none form-to-authorize-input" name="address" id="address" required>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control shadow-none form-to-authorize-input" name="password" id="password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Пароль еще раз</label>
                            <input type="password" class="form-control shadow-none form-to-authorize-input" name="password_confirmation" id="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="confirm" id="checkbox_field" name="checkbox_field" required>
                            <label class="form-check-label align-middle" for="checkbox_field">
                                <p style="padding-left: 7px;">Я принимаю условия <a href="#">Пользовательского соглашения</a></p>
                            </label>
                            @error('checkbox_field.required')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="enter-by-another">
                            <p><strong>Или зарегистрируйтесь с помощью других сервисов</strong></p>
                            <a href="#"><img src="{{asset('images/styles/vk_black.svg')}}" alt=""></a>
                            <a href="#"><img src="{{asset('images/styles/instagram_black.svg')}}"></a>
                            <a href="#"><img src="{{asset('images/styles/twitter_black.svg')}}" alt=""></a>
                        </div>
                        <button class="btn" id="form-to-authorize-button" type="submit">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
            <div class="still-do-not-have-account rounded-4 mt-4 text-center fs-5 pt-4 pb-4 justify-content-center">
                <p>Уже есть аккаунт?<a href="/authorization"> Войдите</a></p>
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
