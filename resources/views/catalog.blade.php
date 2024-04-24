<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/catalog.css') }}">
</head>
<body>
<!-- HEADER -->
@include('includes.header')
<!-- FILTERS AND MAIN -->
<div class="container-fluid">
    <div class="row justify-content-xl-center">
        <div class="col"></div>
        <div class="col-2">
            <div class="filters">
                <form method="GET" action="{{route('showCatalogWithFilters')}}">
                    <h4><strong>Книги</strong></h4>
                    <div class="list-group">
                        <label for="genre-filter" class="form-label mt-3 ui-widget">Сортировка</label>
                        <select class="form-select shadow-none" style="border-color: #20a3dc" name="sortBy" id="genre-filter">
                            <option selected disabled value="">Сортировка по:</option>
                            <option value="rating_asc">Отзывам - возрастание</option>
                            <option value="rating_desc">Отзывам - убывание</option>
                            <option value="price_asc">Цене - возрастание</option>
                            <option value="price_desc">Цена - убывание</option>
                        </select>
                    </div>
                    <div class="list-group">
                        <label for="genre-filter" class="form-label mt-3 ui-widget">Категории</label>
                        <select class="form-select shadow-none" style="border-color: #20a3dc" name="genre" id="genre-filter">
                            <option selected disabled value="">Выберите жанр</option>
                            @foreach($genres as $genre)
                            <option value="{{$genre->id}}">{{$genre->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="authors-filter" class="form-label mt-3 ui-widget">Авторы</label>
                        <input type="text" class="form-control shadow-none filters-inputs" name="author" id="authors-filter" placeholder="Найти автора">
                    </div>
                    <div class="mb-3">
                        <label for="publisher-filter" class="form-label ui-widget">Издательство</label>
                        <input type="text" class="form-control shadow-none filters-inputs" name="publisher" id="publisher-filter" placeholder="Найти издательство">
                    </div>
                    <div class="mb-3">
                        <label for="year-filter" class="form-label ui-widget">Год издания</label>
                        <input type="text" class="form-control shadow-none filters-inputs" name="year" id="year-filter" placeholder="Найти год издания">
                    </div>
                    <h6 class="mt-3">Возрастное ограничение:</h6>
                    <div class="age-checkboxes">
                        <div class="check-age-input">
                            <input class="form-check-input" type="checkbox" value="6+" id="age-6" name="age[]">
                            <label class="form-check-label align-middle" for="age-6">
                                <p>6+</p>
                            </label>
                        </div>
                        <div class="check-age-input">
                            <input class="form-check-input" type="checkbox" value="12+" id="age-12" name="age[]">
                            <label class="form-check-label align-middle" for="age-12">
                                <p>12+</p>
                            </label>
                        </div>
                        <div class="check-age-input">
                            <input class="form-check-input" type="checkbox" value="16+" id="age-16" name="age[]">
                            <label class="form-check-label align-middle" for="age-16">
                                <p>16+</p>
                            </label>
                        </div>
                        <div class="check-age-input">
                            <input class="form-check-input" type="checkbox" value="18+" id="age-18" name="age[]">
                            <label class="form-check-label align-middle" for="age-18">
                                <p>18+</p>
                            </label>
                        </div>
                    </div>
                    <button class="btn d-flex align-items-center" style="width: 100%; justify-content: center;" id="accept-filter" type="submit"><strong>Применить</strong></button>
                    <a href="{{ route('showCatalogWithFilters') }}" class="btn d-flex align-items-center" style="width: 100%; justify-content: center;"><strong>Без фильтров</strong></a>
                </form>
            </div>
        </div>
        <div class="col-9 catalog-cards-div">
            <div class="row row-cols-1 row-cols-md-4 g-4">
                @foreach($books as $book)
                <div class="col">
                    <div class="card h-100">
                        <a href="/book/{{$book->id}}"><img src="{{asset($book->image)}}" class="img-fluid catalog-img" alt="..."></a>
                        <div class="card-body">
                            <h5 class="card-title">{{$book->title}}</h5>
                            @if($book->discount > 0)
                                <p class="card-text fs-5" style="text-decoration: line-through"><strong>{{$book->price}}₽<label class="ms-2" style="color: #ff4545">{{$book->price - $book->discount}}₽</label></strong></p>
                            @else
                                <p class="card-text fs-5"><strong>{{$book->price}}₽</strong></p>
                            @endif
                            <p class="card-subtitle fs-5">
                                <span>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $book->averageRating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                    {{ $book->feedbackCount}} голосов
                                </span></p>
                            <p class="card-text"><a href="#">{{$book->author->full_name}}</a></p>
                            <form method="post" action="{{ route('addToBasket')}}">
                                @csrf
                                <input type="hidden" name="book_id" id="book_id" value="{{ $book->id }}">
                                <button class="btn d-flex align-items-center" style="width: 100%; justify-content: center;" id="accept-filter" type="submit"><strong>Добавить в корзину</strong></button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <nav>
                <ul class="pagination pagination-xl" style="width: 100%; justify-content: center;">
                    <!-- Кнопка "Первая страница" -->
                    <li class="page-item {{ ($books->currentPage() == 1) ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $books->appends(request()->query())->url(1) }}" aria-label="Первая страница">
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
<!-- FOOTER -->
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
    let authors = {!! json_encode($authors_js) !!};
    let publishers = {!! json_encode($publishers_js) !!};
    let years = {!! json_encode($years_js) !!};

    $(function() {
        $("#authors-filter").autocomplete({
            source: authors
        });
    });

    $(function() {
        $("#publisher-filter").autocomplete({
            source: publishers
        });
    });

    $(function() {
        $("#year-filter").autocomplete({
            source: years
        });
    });
</script>
</body>
</html>
