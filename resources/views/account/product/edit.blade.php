@extends('layouts.account')

@section('name', 'account products')

@section('sidebar')
    @include('account.common.sidebar')
@endsection

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="row" style="margin-bottom: 50px;">
            <div class="col-sm">
                <h2>Редактирование продукта {{$product->title}}</h2>
            </div>
        </div>
        <form method="post" action="/products/update/{{$product->product_id}}">
            <div class="form-group">
                <label for="exampleInputEmail1">Название</label>
                <input type="text" value="{{$product->title}}" class="form-control" name="title" aria-describedby="emailHelp" placeholder="Название">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Описание</label>
                <textarea name="description" class="form-control" rows="3">{{$product->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Количество товара</label>
                <input value="{{$product->quantity}}" type="number" min="1" max="100" step="1" name="quantity">
            </div>
            <div>
                <label for="exampleFormControlTextarea1">Цена</label>
                <input value="{{$product->price}}" type="number" min="0.00" max="100000.00" step="0.01" name="price">
            </div>
            <div>
                <label>Статус</label>
                <select class="content" name="status">
                    <option value={{\App\Products::STATUS_ACTIVE}}>В продаже</option>
                    <option value={{\App\Products::STATUS_INACTIVE}}>Снять с продажи</option>
                    <option value={{\App\Products::STATUS_DELETED}}>Удалить</option>
                </select>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </main>
@endsection
