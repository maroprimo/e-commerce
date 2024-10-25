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
        <a href="/edit/{{$produit->id}}" class="btn btn-default">editer</a>
        <a href="/supprimer/{{$produit->id}}" class="btn btn-danger">Delete</a>
        

@endsection