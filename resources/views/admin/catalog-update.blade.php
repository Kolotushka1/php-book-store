<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обновление каталога</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/catalog-update.css') }}">
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
                        <th scope="col">Книга</th>
                        <th scope="col">Автор</th>
                        <th scope="col">Издательство</th>
                        <th scope="col">Год</th>
                        <th scope="col">Стоимость</th>
                        <th scope="col">Возраст</th>
                        <th scope="col">Жанр</th>
                        <th scope="col">Скидка</th>
                        <th scope="col">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books as $book)
                    <tr>
                        <th scope="row">{{$book->id}}</th>
                        <td><a href="/book/{{$book->id}}" class="book-link">{{$book->title}}</a></td>
                        <td><a href="/catalog/filters?author={{$book->author->full_name}}" class="book-link">{{$book->author->full_name}}</a></td>
                        <td><a href="/catalog/filters?publisher={{$book->publisher->name}}" class="book-link">{{$book->publisher->name}}</a></td>
                        <td>{{$book->year}}</td>
                        <td>{{$book->price}}₽</td>
                        <td>{{$book->age}}</td>
                        <td><a href="/catalog/filters?genre={{$book->genre->id}}" class="book-link">{{$book->genre->name}}</a></td>
                        <td>{{$book->discount}}₽</td>
                        <td>
                            <input type="text" id="book-list-id" style="display:none;">
                            <div style="display: flex; gap: 10px; width: 50%;">
                                <a class="btn d-flex align-items-center" style="justify-content: center; margin-right: 0;" href="/admin/update-book/{{$book->id}}" id="form-to-close-order"><strong>Изменить</strong></a>
                                <form method="post" action="{{ route('deleteBook') }}">
                                    @csrf
                                    <input type="hidden" name="book_id" id="book_id" value="{{ $book->id }}">
                                    <button class="btn d-flex align-items-center" style="justify-content: center; background-color: #ff4545; color: black;" id="form-to-close-order" type="submit"><strong>Удалить</strong></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination pagination-xl" style="width: 100%; justify-content: center;">
                        <li class="page-item {{ ($books->currentPage() == 1) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $books->appends(request()->query())->url(1) }}" aria-label="Предыдущая">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                        @php
                            $currentPage = $books->currentPage();
                            $lastPage = $books->lastPage();
                            $leftBound = max(1, $currentPage - 2);
                            $rightBound = min($lastPage, $currentPage + 2);
                        @endphp
                        @for ($i = $leftBound; $i <= $rightBound; $i++)
                            <li class="page-item {{ ($i == $currentPage) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $books->appends(request()->query())->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ ($books->currentPage() == $books->lastPage()) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $books->appends(request()->query())->url($books->lastPage()) }}" aria-label="Последняя страница">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- FOOTER -->
{{--<div class="container-fluid" id="footer" style="background-color: #20A3DC;">--}}
{{--    <div class="row justify-content-xl-center">--}}
{{--        <div class="col"></div>--}}
{{--        <div class="col"></div>--}}
{{--        <div class="col"></div>--}}
{{--        <div class="col"></div>--}}
{{--        <div class="col"></div>--}}
{{--        <div class="col-2 footer-text-center">--}}
{{--            <a href="/" id="myBookFooterLink" class="d-block text-center">МОЯ<strong>КНИГА</strong></a>--}}
{{--            <p class="d-block text-center">2024</p>--}}
{{--        </div>--}}
{{--        <div class="col"></div>--}}
{{--        <div class="col"></div>--}}
{{--        <div class="col-2 social-media-footer">--}}
{{--            <a href="#"><img src="{{asset('images/styles/vk.svg')}}"></a>--}}
{{--            <a href="#"><img src="{{asset('images/styles/instagram.svg')}}"></a>--}}
{{--            <a href="#"><img src="{{asset('images/styles/twitter.svg')}}"></a>--}}
{{--        </div>--}}
{{--        <div class="col"></div>--}}
{{--    </div>--}}
{{--</div>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
