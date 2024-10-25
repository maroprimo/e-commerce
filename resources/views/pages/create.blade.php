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

@section('contenu')
    @if (Session::has('message'))
        <p class="alert alert-success">
            {{Session::get('message')}}
            {{Session::put('message', null)}}
        </p>
        
    @endif
    {{--<form action="{{url('/sauverproduit')}}" method="POST" class="form-horizontal">--}}
    {!!Form::open(['action'=>'PagesController@sauverproduit', 'method'=>'POST', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data'])!!}
        {{ csrf_field() }}
        <div class="form-group">
            {{Form::label('', 'Product')}}
            {{Form::text('product_name', '', ['placeholder'=>'Product Name', 'class'=>'form_control'])}}
            {{--<label>Product</label>
            <input type="text" name="product_name" placeholder="Product Name" class="form-control" required>--}}
        </div>
        <div class="form-group">
            {{Form::label('', 'Product Price')}}
            {{Form::number('product_price', '', ['placeholder'=>'Product Price', 'class'=>'form_control'])}}           
            {{--<label for=""></label>
            <input type="number" name="product_price" placeholder="Product Price" class="form-control" required>--}}
        </div>
        <div class="form-group">
            {{Form::label('', 'Product Image')}}
            {{Form::file('product_image',  ['class'=>'form_control'])}}           
            {{--<label for=""></label>
            <input type="number" name="product_price" placeholder="Product Price" class="form-control" required>--}}
        </div>
        <div class="form-group">
            {{Form::label('', 'Product Description')}}
            {!! Form::textarea('product_description', null, ['id' => 'editor', 'class' => 'form-control', 'cols' => 30, 'rows' => 10]) !!}

            {{--<label>Product Description</label>
            <textarea name="product_description" id="editor" cols="30" rows="10" class="form-control" required></textarea>--}}
        </div>
            {{Form::submit('Ajouter produit', ['class'=>'btn btn-primary'])}}
        {{--<input type="submit" value="Ajouter produit" class="btn btn-primary">--}}
    </form>

@endsection