@extends('layouts.app')

@section('title')
    Sauver produit    
@endsection



@section('contenu')
    @if (Count($errors)>0)
        <p class="alert alert-success">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </p>
        
    @endif

    {{--<form action="{{url('/sauverproduit')}}" method="POST" class="form-horizontal">--}}
    {!!Form::open(['action'=>['ProductController@update', $produit->id], 'method'=>'POST', 'class'=>'form-horizontal'])!!}
        {{ csrf_field() }}
        <div class="form-group">
            {{--ici on va prendre l'id pour pouvoir l'insérer dans la page de facon hidden car
            nous n'avon pas le moyen pour la récupérer--}}
            {{--Form::hidden('id', $produit->id)--}}

            {{Form::label('', 'Product')}}
            {{Form::text('product_name', $produit->product_name, ['placeholder'=>'Product Name', 'class'=>'form_control'])}}
            {{--<label>Product</label>
            <input type="text" name="product_name" placeholder="Product Name" class="form-control" required>--}}
        </div>
        <div class="form-group">
            {{Form::label('', 'Product Price')}}
            {{Form::number('product_price', $produit->product_price, ['placeholder'=>'Product Price', 'class'=>'form_control'])}}           
            {{--<label for=""></label>
            <input type="number" name="product_price" placeholder="Product Price" class="form-control" required>--}}
        </div>
        <div class="form-group">
            {{Form::label('', 'Product Description')}}
            {!! Form::textarea('product_description', $produit->description, ['id' => 'editor', 'class' => 'form-control', 'cols' => 30, 'rows' => 10, 'required' => 'required']) !!}

            {{--<label>Product Description</label>
            <textarea name="product_description" id="editor" cols="30" rows="10" class="form-control" required></textarea>--}}
            {{Form::hidden('_method', 'PUT')}}
        </div>
            {{Form::submit('Editer produit', ['class'=>'btn btn-primary'])}}
        {{--<input type="submit" value="Ajouter produit" class="btn btn-primary">--}}
        {!!Form::close()!!}
    {{--</form>--}}

@endsection