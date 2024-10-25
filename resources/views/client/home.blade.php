@extends('layouts.app1')
@section('title')
    Boutique en ligne de l'art en épice    
@endsection
@section('header')
@section('contenu')


{{--start content--}}
<section id="home-section" class="hero">
 
	{{--Slider section start--}}
	<div class="home-slider owl-carousel">
	@foreach ($sliders as $slider)

			<div class="slider-item" style="background-image: url(/storage/slider_images/{{$slider->slider_image}});">
			<div class="overlay"></div>
			  <div class="container">
				<div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
		
				  <div class="col-md-12 ftco-animate text-center">
					<h1 class="mb-2">{{$slider->description1}}</h1>
					<h2 class="subheading mb-4">{{$slider->description2}}</h2>
					<p><a href="#" class="btn btn-primary">En savoir plus</a></p>
				  </div>
		
				</div>
			  </div>
			</div>			
		@endforeach
	</div>
	{{--slider section end--}}


</section>

<section class="ftco-section">
	  <div class="container">
		  <div class="row no-gutters ftco-services">
	<div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
	  <div class="media block-6 services mb-md-0 mb-4">
		<div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
			  <span class="flaticon-shipped"></span>
		</div>
		<div class="media-body">
		  <h3 class="heading">Livraison rapide</h3>
		  <span>Gratuit</span>
		</div>
	  </div>      
	</div>
	<div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
	  <div class="media block-6 services mb-md-0 mb-4">
		<div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
			  <span class="flaticon-diet"></span>
		</div>
		<div class="media-body">
		  <h3 class="heading">Produits Bio</h3>
		  <span>Emballé</span>
		</div>
	  </div>    
	</div>
	<div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
	  <div class="media block-6 services mb-md-0 mb-4">
		<div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
			  <span class="flaticon-award"></span>
		</div>
		<div class="media-body">
		  <h3 class="heading">Qulité supérieur</h3>
		  <span>Produits de qualité</span>
		</div>
	  </div>      
	</div>
	<div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
	  <div class="media block-6 services mb-md-0 mb-4">
		<div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
			  <span class="flaticon-customer-service"></span>
		</div>
		<div class="media-body">
		  <h3 class="heading">Support</h3>
		  <span>24/7 Support</span>
		</div>
	  </div>      
	</div>
  </div>
	  </div>
  </section>

  <section class="ftco-section ftco-category ftco-no-pt">
	  <div class="container">
		  <div class="row">
			  <div class="col-md-8">
				  <div class="row">
					  <div class="col-md-6 order-md-last align-items-stretch d-flex">
						  <div class="category-wrap-2 ftco-animate img align-self-stretch d-flex" style="background-image: url(frontend/images/DSCN7573.JPG);">
							  <div class="text text-center">
								  <h2>VANILLE</h2>
								  <p>Vanille de Madagascar</p>
								  <p><a href="#" class="btn btn-primary">Découvrez</a></p>
							  </div>
						  </div>
					  </div>
					  
					  
					  <div class="col-md-6">
						@foreach ($categories->slice(0,2) as $categorie)
						<div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url(/storage/product_images/{{$categorie->category_image}});">
							<div class="text px-3 py-1">
								<h2 class="mb-0"><a href="/select_par_cat/{{$categorie->category_name}}">{{$categorie->category_name}}</a></h2>
							</div>
						</div>
						@endforeach
					</div>
						  
					  
				  </div>
			  </div>

			  <div class="col-md-4">
				@foreach ($categories->slice(2,2) as $categorie)
				  <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url(/storage/product_images/{{$categorie->category_image}});">
					  <div class="text px-3 py-1">
						  <h2 class="mb-0"><a href="/select_par_cat/{{$categorie->category_name}}">{{$categorie->category_name}}</a></h2>
					  </div>		
				  </div>
				  @endforeach
			  </div>
		  </div>
	  </div>
  </section>

<section class="ftco-section">
  <div class="container">
		  <div class="row justify-content-center mb-3 pb-3">
	<div class="col-md-12 heading-section text-center ftco-animate">
		<span class="subheading">produits phares</span>
	  <h2 class="mb-4">Nos produits</h2>
	  <p>Nos produits sont certifiés bio et sélectionnés pour vous offrir la meilleure qualité.</p>
	</div>
  </div>   		
  </div>
  <div class="container">
	  <div class="row">

			@foreach ($produits as $produit)
			<div class="col-md-6 col-lg-3 ftco-animate">
				<div class="product">
					<a href="detail/{{$produit->id}}" class="img-prod"><img class="img-fluid" src="/storage/product_images/{{$produit->product_image}}" alt="Colorlib Template">
						<span class="status">30%</span>
						<div class="overlay"></div>
					</a>
					<div class="text py-3 pb-4 px-3 text-center">
						<h3><a href="#">{{$produit->product_name}}</a></h3>
						<div class="d-flex">
							<div class="pricing">
								<p class="price"><span class="mr-2 price-dc">{{$produit->product_price + 1,00}} €</span><span class="price-sale">{{$produit->product_price}} €</span></p>
							</div>
						</div>
						<div class="bottom-area d-flex px-3">
							<div class="m-auto d-flex">
								<a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
									<span><i class="ion-ios-menu"></i></span>
								</a>
								<a href="/ajouter_au_panier/{{$produit->id}}" class="buy-now d-flex justify-content-center align-items-center mx-1">
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
  </div>
</section>
  
  <section class="ftco-section img" style="background-image: url(frontend/images/bg_3.jpg);">
  <div class="container">
		  <div class="row justify-content-end">
	<div class="col-md-6 heading-section ftco-animate deal-of-the-day ftco-animate">
		<span class="subheading">Profitez de notre offre du jour </span>
	  <h2 class="mb-4">Vanille à prix réduit</h2>
	  <p>avec livraison gratuite pour la France. Une qualité exceptionnelle, rien que pour vous !</p>
	  <h3><a href="#">Profitez-en</a></h3>
	  
	  <div id="timer" class="d-flex mt-5">
					<div class="time" id="days"></div>
					<div class="time pl-3" id="hours"></div>
					<div class="time pl-3" id="minutes"></div>
					<div class="time pl-3" id="seconds"></div>
				  </div>
	</div>
  </div>   		
  </div>
</section>

<section class="ftco-section testimony-section">
<div class="container">
  <div class="row justify-content-center mb-5 pb-3">
	<div class="col-md-7 heading-section ftco-animate text-center">
		<span class="subheading">Témoignage</span>
	  <h2 class="mb-4">Clients satisfaits</h2>
	  <p>Je suis enchanté par la qualité des produits et le service impeccable. Une expérience qui dépasse mes attentes à chaque commande !</p>
	</div>
  </div>
  <div class="row ftco-animate">
	<div class="col-md-12">
	  <div class="carousel-testimony owl-carousel">
		<div class="item">
		  <div class="testimony-wrap p-4 pb-5">
			<div class="user-img mb-5" style="background-image: url(frontend/images/person_1.jpg)">
			  <span class="quote d-flex align-items-center justify-content-center">
				<i class="icon-quote-left"></i>
			  </span>
			</div>
			<div class="text text-center">
			  <p class="mb-5 pl-4 line">J'ai été impressionné par la qualité des produits, et la livraison a été super rapide. Je recommande vivement !</p>
			  <p class="name">Garreth Smith</p>
			  <span class="position">Marketing Manager</span>
			</div>
		  </div>
		</div>
		<div class="item">
		  <div class="testimony-wrap p-4 pb-5">
			<div class="user-img mb-5" style="background-image: url(frontend/images/person_2.jpg)">
			  <span class="quote d-flex align-items-center justify-content-center">
				<i class="icon-quote-left"></i>
			  </span>
			</div>
			<div class="text text-center">
			  <p class="mb-5 pl-4 line">Service impeccable, des produits bio et frais, et la livraison gratuite en France est un vrai plus. Très satisfait !</p>
			  <p class="name">Garreth Smith</p>
			  
			</div>
		  </div>
		</div>
		<div class="item">
		  <div class="testimony-wrap p-4 pb-5">
			<div class="user-img mb-5" style="background-image: url(frontend/images/person_3.jpg)">
			  <span class="quote d-flex align-items-center justify-content-center">
				<i class="icon-quote-left"></i>
			  </span>
			</div>
			<div class="text text-center">
			  <p class="mb-5 pl-4 line">Les produits sont d'une qualité exceptionnelle, et le délai de livraison a été respecté. Une expérience d'achat sans faute !</p>
			  <p class="name">Richard</p>
			  
			
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
</section>

<hr>

{{--end content--}}


@endsection