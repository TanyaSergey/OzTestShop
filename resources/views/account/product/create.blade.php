@extends('layouts.account')

@section('name', 'account products')

@section('sidebar')
    @include('account.common.sidebar')
@endsection

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="row" style="margin-bottom: 50px;">
            <div class="col-sm">
                <h2>Новый продукт</h2>
            </div>
        </div>
        <form method="post" action="/products/save" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputEmail1">Название</label>
                <input type="text" class="form-control" name="title" aria-describedby="emailHelp" placeholder="Название">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Описание</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Количество товара</label>
                <input type="number" min="1" max="100" step="1" name="quantity">
            </div>
            <div class="content">
                <h6>Загрузить картинку</h6>
                <label style="margin-right: 20px">Выберите изображение для загрузки:</label>
                <input type="file" name="image" id="image">
            </div>
            <div>
                <label for="exampleFormControlTextarea1">Цена</label>
                <input type="number" min="0.00" max="100000.00" step="0.01" name="price"> бел. руб.
            </div>
            <p></p>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </main>
@endsection
