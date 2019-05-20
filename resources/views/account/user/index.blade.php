@extends('layouts.account')

@section('name', 'account products')

@section('sidebar')
    @include('account.common.sidebar')
@endsection

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="row" style="margin-bottom: 50px;">
            <div class="col-sm">
                <h2>Личные данные пользователя {{$user->email}}</h2>
            </div>
        </div>
        <form method="post" action="/user/edit/{{$user->id}}">
            <div class="form-group">
                <p>Имя: {{$user->first_name ? $user->first_name : ""}}</p>
            </div>
            <div class="form-group">
                <p>Фамилия: {{$user->second_name ? $user->second_name : ""}}</p>
            </div>
            <div class="form-group">
                <p>Email: {{$user->email}}</p>
            </div>
            <div>
                <p>Номер телефона: {{$user->phone ? $user->phone : ""}}</p>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary">редактировать</button>
        </form>
    </main>
@endsection