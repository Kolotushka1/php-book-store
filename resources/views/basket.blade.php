<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Корзина</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/basket.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
</head>
<body>
<!-- HEADER -->
@include('includes.header')
<!-- BASKET -->
<div class="container-fluid">
    <div class="row justify-content-xl-center">
        <div class="col"></div>
        <div class="col-7 form-group rounded-5 mt-4">
            <h2 class="offset-1 mt-4 mb-4 fs-3"><strong>Корзина:</strong></h2>
            @foreach($basketItems as $item)
            <div class="row" style="margin-bottom: 10px">
                <div class="col"></div>
                <div class="col-2 d-flex justify-content-center">
                    <a href="{{route('showCard', ['id' => $item->book->id])}}"><img class="book-basket-img" src="{{asset($item->book->image)}}" alt="book_img"></a>
                </div>
                <div class="col-4">
                    <p class="fs-5">{{$item->book->title}}</p>
                    <a href={{route('showCatalogWithFilters', ['author' => $item->book->author->full_name])}}>{{$item->book->author->full_name}}</a>
                </div>
                <div class="col-2">
                    <div class="counter">
                        <button class="decrement" data-id="{{ $item->id }}">-</button>
                        <span class="value" id="quantity_{{ $item->id }}">{{ $item->quantity }}</span>
                        <button class="increment" data-id="{{ $item->id }}">+</button>
                    </div>
                </div>
                <div class="col-3">
                    @if($item->book->discount > 0)
                        <div style="display: flex; gap: 5px">
                            <p class="fs-5" style="text-decoration: line-through;" id="total_price_without_{{$item->id}}" data-price-without="{{$item->book->price}}">{{ $item->book->price * $item->quantity }}₽</p>
                            <p class="fs-5" id="total_price_{{ $item->id }}" style="color: #ff4545" data-price="{{$item->book->price - $item->book->discount }}">{{ ($item->book->price - $item->book->discount) * $item->quantity }} ₽</p>
                        </div>
                    @else
                        <p class="fs-5" id="total_price_{{ $item->id }}" data-price="{{ $item->book->price }}">{{ $item->book->price * $item->quantity }} ₽</p>
                    @endif
                    <div class="book-action">
                        <form method="post" action="{{route('addUserBookmarks')}}">
                            @csrf
                            <input type="hidden" name="book_id" value="{{$item->book->id}}">
                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                            <button class="btn like-button-basket" type="submit"><img src="{{asset('images/styles/like_blue.svg')}}"></button>
                        </form>
                        <form method="post" action="{{route('deleteFromBasket', $item->id)}}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="book_id" value="{{$item->book->id}}">
                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                            <button class="btn delete-button-basket" type="submit"><img src="{{asset('images/styles/delete_blue.svg')}}"></button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- COST -->
        <div class="col-2">
            <form class="accept-order-form" action="{{ route('acceptOrder') }}" method="post">
                @csrf
                <ul class="list-characters" id="basket_summary">
                    <li class="list-group-item d-flex justify-content-between align-items-center sticky">
                        <strong id="item_count">{{ $basketItems->sum('quantity') }} товар(ов)</strong>
                        <span class="total_price">{{ $totalPrice }} ₽</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Скидка</strong>
                        <span style="color: #FF5555;" class="discount">{{$totalDiscount}} ₽</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <input type="hidden" name="grand_total" id="grand_total" value="{{$totalPrice - $totalDiscount}}">
                        <strong>Итого</strong>
                        <span class="grand_total">{{ $totalPrice - $totalDiscount }} ₽</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Дата</strong>
                        <span><input type="text" name="datepicker" id="datepicker" autocomplete="off" required></span>
                    </li>
                </ul>
                <button class="btn d-flex align-items-center" style="width: 100%; justify-content: center;" id="form-to-accept-order" type="submit"><strong>Оформить</strong></button>
            </form>
        </div>
        <div class="col"></div>
        <div class="col"></div>
    </div>
</div>
<!-- FOOTER -->
@include('includes.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="{{asset('js/script-basket.js')}}"></script>
<script>
    $( function() {
        $( "#datepicker" ).datepicker();
        $( "#anim" ).on( "change", function() {
            $( "#datepicker" ).datepicker( "option", "showAnim", $( this ).val() );
        });
        $.datepicker.regional['ru'] = {
            closeText: 'Закрыть',
            prevText: 'Предыдущий',
            nextText: 'Следующий',
            currentText: 'Сегодня',
            monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
            dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
            dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
            dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            weekHeader: 'Не',
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['ru']);
    } );
</script>
</body>
</html>
