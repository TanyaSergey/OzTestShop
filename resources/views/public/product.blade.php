@extends('layouts.public')

@section('title', 'public product')

@section('header')
    @include('public.header')
@endsection

<script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
<script crossorigin src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<script type="text/babel" src="/js/product/index.js"></script>

@section('content')
    <div id="product-react-component"></div>
    <script type="text/babel">
        ReactDOM.render(
            <Product />,
            document.getElementById('product-react-component')
        );
    </script>
@endsection