@extends('layouts.account')

@section('name', 'account products')

@section('sidebar')
    @include('account.common.sidebar')
@endsection

@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="row" style="margin-bottom: 50px;">
            <div class="col-sm">
                <h2>Ваш проданный товар</h2>
            </div>
        </div>
        <div class="bd-example">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Название продукта</th>
                    <th scope="col" >Цена</th>
                    <th scope="col" >Количество проданных единиц</th>
                    <th scope="col" >Дата покупки</th>
                    <th scope="col" >Данные покупателя</th>
                </tr>
                </thead>
                <tbody>
                @if($products == [])
                    <tr>
                        <td>Вы пока ничего не продали</td>
                    </tr>
                @endif
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->title}}</td>
                        <td>{{$product->price}} бел. руб.</td>
                        <td>{{$product->boughtQuantity}}</td>
                        <td>{{$product->timeBuy}}</td>
                        <td>
                            <p>{{$product->user['email']}}</p>
                            <p>{{$product->user['first_name']}} {{$product->user['second_name']}}</p>
                            <p>{{$product->user['phone']}}</p>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection