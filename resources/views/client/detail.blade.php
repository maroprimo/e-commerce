@extends('layouts.app1')
@section('header')
	
@endsection
@section('contenu')

<div class="hero-wrap hero-bread" style="background-image: url('{{asset('frontend/images/DSCN7627.JPG')}}');">
	<div class="container">
	  <div class="row no-gutters slider-text align-items-center justify-content-center">
		<div class="col-md-9 ftco-animate text-center">
			<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Cart</span></p>
		  <h1 class="mb-0 bread">My Cart</h1>
		</div>
	  </div>
	</div>
  </div>
<section class="ftco-section img">
	<div class="container">
	<div class="row justify-content-end">
	  <div class="col-md-5 heading-section ftco-animate deal-of-the-day ftco-animate">
		<a href="#" class="img-prod"><img class="img-fluid" src="{{ asset('storage/product_images/' . $produit->product_image) }}" alt="Colorlib Template">
			<div class="overlay"></div>
		</a>
	  </div>
	  <div class="col-md-7 heading-section ftco-animate deal-of-the-day ftco-animate">
		  
		<h2 class="mb-4">{{$produit->product_name}}</h2>
		
		<span class="price">{{$produit->product_price}} €</span>
			<table>
				<tr>
					<th>Quantité</th>
					<th></th>
				</tr>
				<tr>
					<td>
						<form action="{{ url('modifier_qty/'.$produit->id) }}" method="POST">

						@csrf
						<label for="quantity">Quantité :</label>
						<input type="number" name="quantity" id="quantity" min="1" value="">
						<button type="submit">Ajouter au Panier</button>
					</form>
					
					</td>
					<td>
						<p><a href="#" class="btn btn-primary py-3 px-4">Mettre à jour la quantité</a></p>
					</td>
				</tr>
			</table>
		<span>Catégorie : {{$produit->product_category}}</span>
		<p><a href="/ajouter_au_panier/{{$produit->id}}" class="btn btn-primary py-3 px-4">Ajouter au panier</a></p>

		<div class="row justify-content-center">
			<div class="col-md-10 mb-5 text-center">
				<ul class="product-category">
					<li><a href="#" class="active">Description</a></li>
					<li><a href="#">Avis</a></li>
				</ul>
			</div>
		</div>
		<div class="row">
		<p class="mb-5 pl-4 line">{{$produit->product_description}}</p>
		</div>
	  </div>
	</div>   		
	</div>
</section>

{{--produits similaire--}}

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-10 mb-5 text-center">
				<h3>Produits similaires</h3>
			</div>
		</div>
		<div class="row">
			@foreach ($produitsSimilaires as $produitsSimilaire)
			<div class="col-md-6 col-lg-3 ftco-animate">
				<div class="product">
					<a href="/detail/{{$produitsSimilaire->id}}" class="img-prod"><img class="img-fluid" src="/storage/product_images/{{$produitsSimilaire->product_image}}" alt="Colorlib Template">
						<span class="status">30%</span>
						<div class="overlay"></div>
					</a>
					<div class="text py-3 pb-4 px-3 text-center">
						<h3><a href="/detail/{{$produitsSimilaire->id}}">{{$produitsSimilaire->product_name}}</a></h3>
						<div class="d-flex">
							<div class="pricing">
								<p class="price"><span class="mr-2 price-dc">{{$produitsSimilaire->product_price}}</span><span class="price-sale">{{$produitsSimilaire->product_price}}</span></p>
							</div>
						</div>
						<div class="bottom-area d-flex px-3">
							<div class="m-auto d-flex">
								<a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
									<span><i class="ion-ios-menu"></i></span>
								</a>
								<a href="/ajouter_au_panier/{{$produitsSimilaire->id}}" class="buy-now d-flex justify-content-center align-items-center mx-1">
									<span><i class="ion-ios-cart"></i></span>
								</a>
								<a href="#" class="heart d-flex justify-content-center align-items-center ">
									<span><i class="ion-ios-heart"></i></span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach


			


		</div>
	<div class="row mt-5">
	  <div class="col text-center">
		<div class="block-27">
		  <ul>
			<li><a href="#">&lt;</a></li>
			<li class="active"><span>1</span></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">&gt;</a></li>
		  </ul>
		</div>
	  </div>
	</div>
	</div>
</section>

{{--fin produit similaire--}}

@endsection