<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ панель</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/admin.css') }}">
</head>
<body>
<!-- HEADER -->
    <div class="container-fluid" id="header">
        <div class="row justify-content-xl-center">
            <div class="col"></div>
            <div class="col-2">
                <a href="/" id="myBookHeaderLink" class="d-block text-center">МОЯ<strong>КНИГА</strong></a>
            </div>
            <div class="col" style="position: relative;">
                <p id="user-name">Админ</p>
            </div>
            <div class="col-4">
                @include('includes.search')
            </div>
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col"></div>
        </div>
    </div>
    <!-- MAIN -->
    <div class="container-fluid">
        <div class="row justify-content-xl-center">
            <div class="col-2">
                @include('includes.admin-left-part')
            </div>
            <div class="col-10">
                <div class="table-with-info">
                    <table class="table table-info" style="border-collapse: separate; border-spacing: 0 20px;">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Email</th>
                            <th scope="col">Книги</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Стоимость</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <th scope="row">{{ $order->id }}</th>
                            <td>{{ $order->user->full_name }}</td>
                            <td>{{ $order->user->phone }}</td>
                            <td>{{ $order->user->address }}</td>
                            <td>{{ $order->user->email }}</td>
                            <td>
                                @foreach($order->items as $item)
                                    <a href="/book/{{$item->book->id}}" class="book-link">{{ $item->book->title }}; </a>
                                @endforeach
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->date)->format('d.m.Y') }}</td>
                            <td>{{ $order->cost }}₽</td>
                            <td>
                                @if($order->status == 0)
                                    Обработка
                                @else
                                    Выполнен
                                @endif
                            </td>
                            <td>
                                <form method="post" action="{{ route('updateOrderStatus') }}">
                                    <input type="text" id="book-list-id" style="display:none;">
                                    @csrf
                                    @method('PUT')
                                    @if($order->status == 0)
                                        <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
                                        <button class="btn d-flex align-items-center" style="width: 100%; justify-content: center;" id="form-to-close-order" type="submit"><strong>Завершить</strong></button>
                                    @else
                                        <button disabled class="btn d-flex align-items-center" style="width: 100%; justify-content: center;" id="form-to-close-order" type="submit"><strong>Выполнен</strong></button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ ($orders->currentPage() == 1) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $orders->previousPageUrl() }}">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                <li class="page-item {{ ($orders->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ ($orders->currentPage() == $orders->lastPage()) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $orders->nextPageUrl() }}">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- FOOTER -->
{{--    <div class="container-fluid" id="footer" style="background-color: #20A3DC;">--}}
{{--        <div class="row justify-content-xl-center">--}}
{{--            <div class="col"></div>--}}
{{--            <div class="col"></div>--}}
{{--            <div class="col"></div>--}}
{{--            <div class="col"></div>--}}
{{--            <div class="col"></div>--}}
{{--            <div class="col-2 footer-text-center">--}}
{{--                <a href="/" id="myBookFooterLink" class="d-block text-center">МОЯ<strong>КНИГА</strong></a>--}}
{{--                <p class="d-block text-center">2024</p>--}}
{{--            </div>--}}
{{--            <div class="col"></div>--}}
{{--            <div class="col"></div>--}}
{{--            <div class="col-2 social-media-footer">--}}
{{--                <a href="#"><img src="{{asset('images/styles/vk.svg')}}"></a>--}}
{{--                <a href="#"><img src="{{asset('images/styles/instagram.svg')}}"></a>--}}
{{--                <a href="#"><img src="{{asset('images/styles/twitter.svg')}}"></a>--}}
{{--            </div>--}}
{{--            <div class="col"></div>--}}
{{--        </div>--}}
{{--    </div>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
    window.onload = function () {
        let orderCount = {!! $orders->count() !!};
        if (orderCount < 6) {
            document.getElementById('footer').style.position = 'fixed';
            document.getElementById('footer').style.bottom = '0';
        } else {
            document.getElementById('footer').style.position = 'static';
            document.getElementById('footer').style.bottom = '';
        }
    };
</script>
</body>
</html>
