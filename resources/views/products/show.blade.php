@extends('layouts.app')

@section('title')
    detail    
@endsection

@section('contenu')

        <h1>Welcome to the product show</h1>
        <hr>
        <h2>{{$produit->product_name}} </h2>
        <h3>Prix: {{$produit->product_price}} €</h3>
        <p>{!!$produit->description!!} </p>
        <hr>
        <h4>{{$produit->created_at}} </h4>
        <hr>
        <a href="/products/{{$produit->id}}/edit" class="btn btn-default">editer</a>
        
        {!!Form::open(['action'=>['ProductController@destroy', $produit->id], 'class'=>'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
        {!!Form::close()!!}
        

@endsection