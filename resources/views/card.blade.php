<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Карточка товара</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/card.css') }}">
</head>
<body>
<!-- HEADER -->
@include('includes.header')
<!-- BOOK INFO -->
<div class="container-fluid">
    <div class="row justify-content-xl-center">
        <div class="col"></div>
        <div class="col-7 rounded-5">
            <div class="main-book-info rounded-5 mt-4 ps-4 pe-4">
                <div class="mt-4 card-top-main">
                    <p style="font-weight: bold;" id="genre-of-book">Книги ><a href="{{route('showCatalogWithFilters', ['genre' => $book->genre])}}">{{$book->genre->name}}</a></p>
                    <p id="name-of-book" class="fs-3"><strong>{{$book->title}}</strong></p>
                    <a class="fs-5" href={{route('showCatalogWithFilters', ['author' => $book->author])}}>{{$book->author->full_name}}</a>
                    <p id="rating-top">
                        <small class="text-body fs-5">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $book->averageRating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                            {{ $book->feedbackCount}} голосов
                        </small>
                    </p>
                </div>
                <div class="main-revisions">
                    <div class="col-xl-12 my-card">
                        <div class="mb-4">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <a href="{{route('showCard', ['id' => $book->id])}}"><img src="{{asset($book->image)}}"  class="img-fluid rounded-start" style="width: 100%;" alt="..."></a>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body" style="height: 100%;">
                                        <h6 class="card-subtitle">{{$book->description}}</h6>
                                        <div class="col-5 column-of-characters">
                                            <ul class="list-characters">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    ID товара:
                                                    <span class="">{{$book->id}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Издательство:
                                                    <span class=""><a href="#" id="publisher">{{$book->publisher->name}}</a></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    ISBN:
                                                    <span class="">{{$book->isbn}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Год издания:
                                                    <span class="">{{$book->year}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Количество страниц:
                                                    <span class="">{{$book->page_count}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Тип обложки:
                                                    <span class="">{{$book->cover_type}}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Тираж:
                                                    <span class="">{{$book->edition}}00</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Возрастные ограничения:
                                                    <span class="">{{$book->age}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-book-info rounded-5 mt-4 ps-4 pe-4">
                <p class="fs-3 pt-3"><strong>Отзывы: {{$book->feedbackCount}}</strong></p>

                <button id="openFormBtn" class="btn">Оставить отзыв</button>
                <div class="form-popup" id="feedback-user-form">
                    <form class="form-container mb-2" method="post" action="{{route('addFeedback', $book->id)}}">
                        @csrf
                        <h2>Как вам книга?</h2>
                        <input type="text" placeholder="Заголовок" class="form-control shadow-none mb-2" id="feedback-article-user" name="feedback-article-user" required></input>
                        <textarea placeholder="Поделитесь своим мнением!" class="form-control" id="feedback-text-user" name="feedback-text-user" required></textarea>
                        <select class="form-select mb-2" aria-label="Default select example" name="stars">
                            <option selected value="1">★</option>
                            <option value="2">★★</option>
                            <option value="3">★★★</option>
                            <option value="4">★★★★</option>
                            <option value="5">★★★★★</option>
                        </select>
                        <div class="feedback-user-buttons">
                            <button type="submit" class="btn conf fs-5">Отправить</button>
                            <button type="button" class="btn cancel fs-5" id="closeFormBtn">Закрыть</button>
                        </div>
                    </form>
                </div>

                @foreach($feedbacks->take(2) as $feedback)
                <div class="feedback @if($feedback->rating >= 3) feedback-good @else feedback-bad @endif">
                    <div class="feedback-top">
                        <p class="name">{{$feedback->user->full_name}}</p>
                        <p class="date">{{$feedback->created_at->format('d.m.Y')}}</p>
                    </div>
                    <p id="feedback-stars" class="fs-5">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $feedback->rating)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </p>
                    <p class="fs-5"><strong>{{$feedback->title}}</strong></p>
                    <p>{{$feedback->review}}</p>
                </div>
                @endforeach
                <div id="hiddenFeedbacks" style="display: none;">
                    @foreach($feedbacks->skip(2) as $feedback)
                    <div class="feedback @if($feedback->rating >= 3) feedback-good @else feedback-bad @endif">
                        <div class="feedback-top">
                            <p class="name">{{$feedback->user->full_name}}</p>
                            <p class="date">{{$feedback->created_at->format('d.m.Y')}}</p>
                        </div>
                        <p id="feedback-stars" class="fs-5">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $feedback->rating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </p>
                        <p class="fs-5"><strong>{{$feedback->title}}</strong></p>
                        <p>{{$feedback->review}}</p>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn show-more" id="loadMoreButton">Показать ешё</button>
                </div>
            </div>
        </div>
        <!-- COST -->
        <div class="col-2 cost rounded-5 ms-4 mt-4 ps-4 pe-4 sticky" style="@if(auth()->check() and auth()->user()->role_id == 1) height:225px @else height:135px @endif">
            @if($book->discount > 0)
                <p class="fs-5 mt-4" style="text-decoration: line-through"><strong>{{$book->price}}₽<label class="ms-1" style="color: #ff4545">{{$book->price - $book->discount}}₽</label></strong></p>
            @else
                <p class="fs-5 mt-4"><strong>{{$book->price}}₽</strong></p>
            @endif
            <div class="cost-div">
                <form method="post" action="{{ route('addToBasket')}}">
                    @csrf
                    <input type="hidden" name="book_id" id="book_id" value="{{ $book->id }}">
                    <button class="btn" id="form-to-add-to-busket" type="submit"><strong>В корзину</strong></button>
                </form>
                <form method="post" action="{{route('addUserBookmarks')}}">
                    @csrf
                    <input type="hidden" value="{{$book->id}}" name="book_id">
                    @if(auth()->check())
                        <input type="hidden" value="{{ auth()->user()->id}}" name="user_id">
                    @endif
                    <button class="btn" id="form-to-add-to-likes" type="submit"><img src="{{asset('images/styles/like_blue.svg')}}"></button>
                </form>
            </div>
            @if(auth()->check() and auth()->user()->role_id == 1)
                <a id="change-card" style="text-decoration: none !important" href="{{route('showUpdateBook', ['id' => $book])}}">Изменить</a>
            @endif
        </div>
        <div class="col"></div>
        <div class="col"></div>
    </div>
</div>
<!-- FOOTER -->
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src={{asset("js/script-card.js")}}></script>
</body>
</html>
