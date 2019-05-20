@extends('layouts.public')

@section('title', 'public')

@section('header')
    @include('public.header')
@endsection

<script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
<script crossorigin src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<script type="text/babel" src="/js/product/mainPage.js"></script>
<link rel="stylesheet" type="public/css" href="{{ asset('public/css/public.css') }}" />

@section('content')
    <div id="mainPage-react-component"></div>
    <script type="text/babel">
        ReactDOM.render(
            <MainPage />,
            document.getElementById('mainPage-react-component')
        );
    </script>
@endsection