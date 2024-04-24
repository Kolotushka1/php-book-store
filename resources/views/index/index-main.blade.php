<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>МОЯКНИГА - главная страница</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index-style.css') }}">
</head>
<body>
<!-- HEADER -->
@include('includes.header')
<!-- BOOKS BY GENRE -->
<div class="container-fluid">
    <div class="row justify-content-xl-center">
        <div class="col"></div>
        <div class="col-2">
            <div class="books-by-genre d-block text-center">
                <p>Книги по жанру</p>
                <a href="/">Все жанры</a>
                @foreach ($genres as $genre)
                    <a href="{{ route('books-by-genre', ['genre' => $genre->id]) }}">{{$genre->name}}</a>
                @endforeach
            </div>
        </div>
        <div class="col-9 books-by-genre-main">
            <div class="row">
                <p id="booksByGenreText" class="col-xl-4 offset-1">Все жанры - последние</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 g-4 offset-1">
                @foreach($latestBooks as $book)
                <div class="col-xl-6 my-card">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <a href={{asset("book/" . $book->id)}}><img src="{{asset($book->image)}}" class="img-fluid rounded-start img-of-book" alt="..."></a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><a href={{asset("book/" . $book->id)}} class="card-link">{{$book->title}}</a></h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary"><a href={{asset("author/" . $book->author->id)}} class="card-link">{{$book->author->full_name}}</a></h6>
                                    <p>
                                        <small class="text-body-secondary">
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
                                    <p class="card-text"><small class="text-body-secondary">{{$book->description}}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- FOOTER -->
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
