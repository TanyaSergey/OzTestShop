@section('header')
    <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <strong>Shop</strong>
            </a>
            <a href="/cart" class="header-category-item">
                @if(\Illuminate\Support\Facades\Auth::user())
                    <a href="/products" class="navbar-brand d-flex align-items-center">
                        <strong>Личный кабинет</strong>
                    </a>
                @elseif(!\Illuminate\Support\Facades\Auth::user())
                    <a href="/login" class="navbar-brand d-flex align-items-center">
                        <strong>Вход/Регистрация</strong>
                    </a>
                @endif
                <a href="/cart">
                    <img  width="40px" src="/imagies/cart.png">
                    <span class="counter-cart-data" id="counter-cart-data"></span>
                </a>
            </a>
        </div>
    </div>
@endsection