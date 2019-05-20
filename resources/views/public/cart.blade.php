@extends('layouts.public')

@section('title', 'public cart')

@section('header')
    @include('public.header')
@endsection

<script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
<script crossorigin src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<script type="text/babel" src="/js/cart/index.js"></script>

@section('content')
    <div id="cart-react-component"></div>
    <script type="text/babel">
        ReactDOM.render(
            <Cart />,
            document.getElementById('cart-react-component')
        );
    </script>
@endsection
