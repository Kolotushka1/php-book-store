<!-- HEADER -->
<div class="container-fluid" id="header">
    <div class="row justify-content-xl-center">
        <div class="col"></div>
        <div class="col-2">
            <a href="/" id="myBookHeaderLink" class="d-block text-center">МОЯ<strong>КНИГА</strong></a>
        </div>
        <div class="col-4" style="position: relative;">
            @include('includes.search')
        </div>
        <div class="col">
            <a href="{{route('showCatalog')}}" class="d-block text-center header-links">
                <img src="{{asset('images/styles/catalog.svg')}}">
                <p>Каталог</p>
            </a>
        </div>
        <div class="col">
            <a href="{{route('showUserPage')}}" class="d-block text-center header-links">
                <img src="{{asset('images/styles/like.svg')}}"></img>
                <p>Закладки</p>
            </a>
        </div>
        <div class="col">
            <a href="{{route('showBasketPage')}}" class="d-block text-center header-links">
                <img src="{{asset('images/styles/basket.svg')}}"></img>
                <p>
                    Корзина
                    @if(auth()->check())
                        @php
                            $count = 0;
                            $userId = auth()->user()->id;
                            try {
                                $basketId = \App\Models\Basket::where('user_id', $userId)->first();
                                $basketItems = \App\Models\BasketItem::where('basket_id', $basketId->id)->get();
                                foreach ($basketItems as $item) {
                                    $count += $item->quantity;
                                }
                            }
                            catch (ErrorException) {
                                $count == 0;
                            }
                        @endphp
                        @if($count > 0)
                            ({{ $count }})
                        @else
                            (0)
                        @endif
                    @endif
                </p>
            </a>
        </div>
        <div class="col">
            @if(auth()->check())
                <a href="{{route('showUserPage')}}" class="d-block text-center header-links">
                    <img src="{{asset('images/styles/user.svg')}}"></img>
                    <p>Аккаунт</p>
                </a>
            @else
                <a href="{{route('authorization')}}" class="d-block text-center header-links">
                    <img src="{{asset('images/styles/user.svg')}}"></img>
                    <p>Войти</p>
                </a>
            @endif
        </div>
        <div class="col"></div>
    </div>
</div>
