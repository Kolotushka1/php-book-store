<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Страница пользователя</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user.css') }}">
</head>
<body>
<!-- HEADER -->
@include('includes.header')
<!-- MAIN CONTENT -->
<div class="row justify-content-xl-center">
    <div class="col"></div>
    <div class="col-3">
        <div class="user-sections">
            <div class="list-group">
                <h5>Разделы:</h5>
                <a href="" class="list-group-item list-group-item-action fs-5" data-target="personal-data"><img src="{{asset('images/styles/your-profile.svg')}}" class="pe-3">Личные данные</a>
                <a href="" class="list-group-item list-group-item-action fs-5" data-target="orders"><img src="{{asset('images/styles/your-orders.svg')}}" class="pe-3">Заказы</a>
                <a href="" class="list-group-item list-group-item-action fs-5" data-target="bookmarks"><img src="{{asset('images/styles/your-saved.svg')}}" class="pe-3">Закладки</a>
                <a href="{{route('logout')}}" class="list-group-item list-group-item-action fs-5"><img src="{{asset('images/styles/your-leave.svg')}}" class="pe-3">Выход из аккаунта</a>
            </div>
        </div>
    </div>
    <div class="col-7">
        <div class="container">
            <div id="personal-data" class="user-section" style="display: none;">
                <h2>Личные данные</h2>
                <form method="post" action="{{ route('updateUserInfo') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <div class="col-xl-6">
                            <label for="exampleInputEmail1" class="form-label">Адрес электронной почты:</label>
                            <input name="user-email" type="email" class="form-control" value="{{$user->email}}" placeholder="{{$user->email}}" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                        <div class="col-xl-6">
                            <label for="exampleInputEmail1" class="form-label">ФИО:</label>
                            <input name="user-full-name" type="text" class="form-control" value="{{$user->full_name}}" placeholder="{{$user->full_name}}" required>
                        </div>
                        <div class="col-xl-6">
                            <label for="exampleInputEmail1" class="form-label">Номер телефона:</label>
                            <input name="user-phone-number" type="text" class="form-control" value="{{$user->phone}}" placeholder="{{$user->phone}}" required>
                        </div>
                        <div class="col-xl-6">
                            <label for="exampleInputEmail1" class="form-label">Адрес:</label>
                            <input name="user-address" type="text" class="form-control" value="{{$user->address}}" placeholder="{{$user->address}}" required>
                        </div>
                    </div>
                    <button class="btn d-flex align-items-center mt-3" style="width: 100%; justify-content: center;" id="form-to-change-data" type="submit"><strong>Сохранить</strong></button>
                </form>
                @if(session('success'))
                    <div class="alert mt-3 alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div id="orders" class="user-section" style="display: none;">
                <h2>Заказы</h2>
                @foreach($orders as $order)
                <form method="post" action="{{ route('deleteUserOrder') }}" class="order-class">
                    @csrf
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    <div class="card" style="margin-top: 10px;">
                        <div class="card-body">
                            <h5 class="card-title">Заказ #{{$order->id}} от {{$order->created_at->format('d.m.Y')}}</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">{{$user->address}}</h6>
                            <p class="card-text">Стоимость: {{$order->cost}} ₽</p>
                            @foreach($order->items as $item)
                                <a href="{{route('showCard', ['id' => $item->book->id])}}"><img src="{{asset($item->book->image)}}"></a>
                            @endforeach
                            @if($order->status == 0)
                                <p class="order-status">В обработке</p>
                                <button class="btn d-flex align-items-center mt-3" style="width: 100%; justify-content: center;" id="form-to-delete-order" type="submit"><strong>Отменить</strong></button>
                            @else
                                <p class="order-status">Завершен</p>
                            @endif
                        </div>
                    </div>
                </form>
                @endforeach
            </div>
            <div id="bookmarks" class="user-section" style="display: none;">
                <h2>Закладки</h2>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach($bookmarks as $bookmark)
                        <div class="col-xl-6">
                            <form method="post" action="{{ route('deleteUserBookmarks') }}">
                                @csrf
                                <input type="hidden" name="bookmark_id" value="{{$bookmark->id}}">
                                <div class="card" style="margin-top: 10px;">
                                    <div class="card-body saved-book">
                                        <h5 class="card-title">{{$bookmark->book->title}}</h5>
                                        <h6 class="card-subtitle mb-2 text-body-secondary">{{$bookmark->book->author->full_name}}</h6>
                                        <p class="card-text">Издательство: {{$bookmark->book->publisher->name}}</p>
                                        <p class="card-text">Год: {{$bookmark->book->year}}</p>
                                        <p class="card-text">Стоимость: {{$bookmark->book->price}} ₽</p>
                                        <a href="{{route('showCard', ['id' => $bookmark->book->id])}}"><img style="margin-top: 5px;" src="{{asset($bookmark->book->image)}}"></a>
                                        <button class="btn d-flex align-items-center mt-3" style="width: 100%; justify-content: center;" id="form-to-delete-like" type="submit"><strong>Удалить</strong></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
</div>
<!-- FOOTER -->
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src={{asset("js/user-page-script.js")}}></script>
</body>
</html>
