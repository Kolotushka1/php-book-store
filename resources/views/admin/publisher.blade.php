<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Издательство</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/publisher.css') }}">
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
                            <th scope="col">Имя</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($publishers as $publisher)
                            <tr>
                                <th scope="row">{{ $publisher->id }}</th>
                                <td><a href="{{route('showCatalogWithFilters', ['publisher' => $publisher->name])}}" class="book-link">{{$publisher->name}}</a></td>
                                <td>{{ $publisher->phone }}</td>
                                <td>{{ $publisher->address }}</td>
                                <td>
                                    <input type="text" id="book-list-id" style="display:none;">
                                    <div style="display: flex; gap: 10px; width: 50%;">
                                        <a class="btn d-flex align-items-center" style="justify-content: center; margin-right: 0;" href="/admin/publisher/?publisherToUpdateId={{$publisher->id}}" id="form-to-close-order"><strong>Изменить</strong></a>
                                        <form method="post" action="{{ route('deletePublisher') }}">
                                            @csrf
                                            <input type="hidden" name="publisherToDeleteId" id="publisherToDeleteId" value="{{ $publisher->id }}">
                                            <button class="btn d-flex align-items-center" style="justify-content: center; background-color: #ff4545; color: black;" id="form-to-close-order" type="submit"><strong>Удалить</strong></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ ($publishers->currentPage() == 1) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $publishers->previousPageUrl() }}">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $publishers->lastPage(); $i++)
                                <li class="page-item {{ ($publishers->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $publishers->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ ($publishers->currentPage() == $publishers->lastPage()) ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $publishers->nextPageUrl() }}">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                @if(session('success'))
                    <div class="alert alert-success mt-3 mb-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if($publisherToUpdate)
                    <form method="post" action="{{route('updatePublisher')}}" class="new-publisher p-4 mb-4">
                        @csrf
                        <input type="hidden" name="publisherToUpdate" value="@if($publisherToUpdate) {{$publisherToUpdate->id }} @endif">
                        <div class="mb-3">
                            <label for="name" class="form-label">Название</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$publisherToUpdate->name}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{$publisherToUpdate->phone}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Адрес</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{$publisherToUpdate->address}}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Изменить</button>
                    </form>
                @else
                    <form method="post" action="{{route('addPublisher')}}" class="new-publisher p-4 mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Название</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Адрес</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                @endif
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
        {{--window.onload = function () {--}}
        {{--    let publisherCount = {!! $publishers->count() !!};--}}
        {{--    if (publisherCount < 6) {--}}
        {{--        document.getElementById('footer').style.position = 'fixed';--}}
        {{--        document.getElementById('footer').style.bottom = '0';--}}
        {{--    } else {--}}
        {{--        document.getElementById('footer').style.position = 'static';--}}
        {{--        document.getElementById('footer').style.bottom = '';--}}
        {{--    }--}}
        {{--};--}}
    </script>
</body>
</html>
