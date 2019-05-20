@extends('layouts.account')

@section('name', 'account products')

@section('sidebar')
    @include('account.common.sidebar')
@endsection

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="row" style="margin-bottom: 50px;">
            <div class="col-sm">
                <h2>Редактирование данных пользователя {{$user->email}}</h2>
            </div>
        </div>
        <form method="post" action="/user/update/{{$user->id}}">
            <div class="form-group">
                <label for="exampleInputEmail1">Имя</label>
                <input type="text" value="{{$user->first_name}}" class="form-control" name="first_name" aria-describedby="emailHelp" placeholder="Ваше имя">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Фамилия</label>
                <input type="text" value="{{$user->second_name}}" class="form-control" name="second_name" aria-describedby="emailHelp" placeholder="Ваша Фамилия">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Телефон</label>
                <input value="{{$user->phone}}" type="tel" name="phone">
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </main>
@endsection
