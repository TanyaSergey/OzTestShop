@extends('layouts.account')

@section('name', 'account products')

@section('sidebar')
    @include('account.common.sidebar')
@endsection

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="row" style="margin-bottom: 50px;">
            <div class="col-sm">
                <h2>Ваш личный кабинет</h2>
                <h2>Продукты</h2>
            </div>
            <div class="col-sm">
                <a href="/products/create">
                    <button type="button" class="btn btn-primary">Добавить продукт</button></a>
            </div>
        </div>
        <div class="bd-example">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Название продукта</th>
                    <th scope="col">Статус продукта</th>
                    <th scope="col" >Картинка</th>
                    <th scope="col" >Цена</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <th scope="row">{{$product->product_id}}</th>
                        <td><a href="/products/edit/{{$product->product_id}}">{{$product->title}}</a></td>
                        @if ($product->status == \App\Products::STATUS_ACTIVE)
                        <td><a href="/products/edit/{{$product->product_id}}">В продаже</a></td>
                        @elseif ($product->status == \App\Products::STATUS_INACTIVE)
                        <td><a href="/products/edit/{{$product->product_id}}">снят с продажи</a></td>
                        @endif
                        <td>
                            @if ($product->image)
                                <img src="/imagies/product/{{$product->image}}" width="100ox">
                            @endif
                        </td>
                        <td><a href="/products/edit/{{$product->product_id}}">{{$product->price}} бел. руб.</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($products->count() === 0)
                <p>Вы пока не добавили ни одного продукта</p>
            @endif
        </div>
    </main>
@endsection