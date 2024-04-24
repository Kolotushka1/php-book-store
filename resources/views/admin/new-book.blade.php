<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новая книга</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/new-book.css') }}">
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
<!-- MAIN CONTENT -->
<div class="container-fluid">
    <div class="row justify-content-xl-center">
        <div class="col-2">
            @include('includes.admin-left-part')
        </div>
        <div class="col-10">
            <form class="form-to-create-new-book" method="post" action="{{ route('createBook') }}" enctype="multipart/form-data">
                @csrf
                <input type="text" id="hidden-id" style="display:none;">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-3">
                        <img id="previewImage" src="{{ asset('images/books/no-foto.svg') }}" style="height: auto; height: 330px; width: 217px;">
                        <div class="mt-3">
                            <input class="form-control" type="file" id="formFile" name="formFile" placeholder="">
                        </div>
                    </div>
                    <div class="col-4">
                        <label>Название книги</label>
                        <input name="name-of-book" class="form-control shadow-none" type="text" placeholder="Название" aria-label="пример ввода по умолчанию">
                        <label for="publisher-filter" class="form-label ui-widget" style="margin-bottom: 0;" id="publisher-new-book">Издательство</label>
                        <input type="text" class="form-control shadow-none filters-inputs" id="publisher-filter" name="publisher" placeholder="Найти издательство">
                        <label>Цена</label>
                        <input class="form-control shadow-none" type="text" name="price" aria-label="пример ввода по умолчанию">
                        <label>Год</label>
                        <input class="form-control shadow-none" type="text" name="year" aria-label="пример ввода по умолчанию">
                        <label>Количество страниц</label>
                        <input class="form-control shadow-none" type="text" name="pages" aria-label="пример ввода по умолчанию">
                        <label>Обложка</label>
                        <input name="cover" class="form-control shadow-none" type="text" placeholder="твердая/мягкая" aria-label="пример ввода по умолчанию">
                    </div>
                    <div class="col-4">
                        <label>Тираж</label>
                        <input class="form-control shadow-none" type="text" name="edition" placeholder="В сотнях" aria-label="пример ввода по умолчанию">
                        <label>Возраст</label>
                        <input class="form-control shadow-none" type="text" name="age" aria-label="пример ввода по умолчанию">
                        <label for="authors-filter" class="form-label ui-widget" style="margin-bottom: 0;" style="margin-bottom: 0;" id="author-new-book">Автор</label>
                        <input type="text" class="form-control shadow-none filters-inputs" id="authors-filter" name="author" placeholder="Найти автора">
                        <label for="genres-filter" class="form-label ui-widget" style="margin-bottom: 0;" style="margin-bottom: 0;" id="genre-new-book">Жанр</label>
                        <input type="text" class="form-control shadow-none filters-inputs" id="genres-filter" name="genre" placeholder="Найти жанр">
                        <label>Скидка</label>
                        <input class="form-control shadow-none" placeholder="1->Без скидки" type="text" name="discount" aria-label="пример ввода по умолчанию">
                        <label>ISBN</label>
                        <input name="ISBN" class="form-control shadow-none" type="text" aria-label="пример ввода по умолчанию">
                    </div>
                    <div class="col"></div>
                </div>
                <textarea placeholder="Описание книги!" style="width: 50%; justify-content: center; margin-left: 25%;" class="form-control mt-3" id="description-book" name="description-book" required></textarea>
                <button class="btn d-flex align-items-center mt-4" style="width: 50%; justify-content: center; margin-left: 25%;" id="form-to-add-book" type="submit"><strong>Оформить</strong></button>
            </form>
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
    let authors = {!! json_encode($authors_js) !!};
    let publishers = {!! json_encode($publishers_js) !!};
    let genres = {!! json_encode($genres_js) !!};

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
        $("#genres-filter").autocomplete({
            source: genres
        });
    });

    document.getElementById('formFile').addEventListener('change', function(event) {
        let input = event.target;
        let reader = new FileReader();
        reader.onload = function() {
            let dataURL = reader.result;
            let output = document.getElementById('previewImage');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    });
</script>
</body>
</html>
