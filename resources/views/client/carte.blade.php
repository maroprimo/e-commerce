@extends('layouts.app1')
@section('contenu')


{{--start content--}}

    <div class="hero-wrap hero-bread" style="background-image: url('frontend/images/DSCN7627.JPG');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Cart</span></p>
            <h1 class="mb-0 bread">My Cart</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-cart">
			<div class="container">
			<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="cart-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>
						        <th>&nbsp;</th>
						        <th>Product name</th>
						        <th>Price</th>
						        <th>Quantity</th>
								<th>Poids</th>
						        <th>Total</th>
						      </tr>
						    </thead>
							@if (Session::has('cart') && $products)
							<tbody>
								@foreach ($products as $product)
								<tr class="text-center">
									<td class="product-remove"><a href="/retirer_produit/{{$product['product_id']}}"><span class="ion-ios-close"></span></a></td>
						
									<td class="image-prod">
										<div class="img" style="background-image:url(/storage/product_images/{{$product['product_image']}});"></div>
									</td>
						
									<td class="product-name">
										<h3>{{$product['product_name']}}</h3>
									</td>
						
									<td class="price">{{$product['product_price']}}</td>
									<form action="{{url('modifier_qty/'.$product['product_id'])}}" method="post">
										{{csrf_field()}}
										<td class="quantity">
											<div class="input-group mb-3">
												<input type="number" name="quantity" class="quantity form-control input-number" value="{{$product['qty']}}" min="1" max="100">
											</div>
											<input type="submit" value="Mettre à jour le panier" class="btn btn-success">
										</td>
									</form>	
									<td class="price">{{$product['weight'] * $product['qty']}} g</td>
									<td class="total">{{$product['product_price'] * $product['qty']}} €</td>
								</tr>
								@endforeach
							</tbody>
						@else
							<p></p>
						@endif
						@if (Session::has('status'))
						<div class="alert alert-success">
							{{ Session::get('status') }}
						</div>
						@endif
						</table>
						</div>
						</div>
						</div>
						
						<div class="row justify-content-end">
							<div class="col-lg-4 mt-5 cart-wrap ftco-animate">
								<div class="cart-total mb-3">
									<h3>Code promo</h3>
									<p>Entrez votre code promo</p>
									<form action="#" class="info">
										<div class="form-group">
											<label for="">Coupon code</label>
											<input type="text" class="form-control text-left px-3" placeholder="">
										</div>
									</form>
								</div>
								<p><a href="checkout.html" class="btn btn-primary py-3 px-4">Apply Coupon</a></p>
							</div>
						
							<div class="col-lg-4 mt-5 cart-wrap ftco-animate">
								<div class="cart-total mb-3">
									<h3>Estimation des frais d'expédition</h3>
									<p>Entrez pays destination</p>
									<form action="{{ route('updateCountry') }}" method="POST">
										@csrf
										<div class="form-group">
											<label for="country">Votre pays</label>
											<select name="country_id" class="form-control text-left px-3" required>
												<option value="">Sélectionnez votre pays</option>
												@foreach($countries as $country)
													<option value="{{ $country->id }}">{{ $country->name }}</option>
												@endforeach
											</select>
										</div>
										<input type="submit" class="btn btn-primary" value="Valider le pays">
									</form>
								</div>
							</div>
						
							<div class="col-lg-4 mt-5 cart-wrap ftco-animate">
								<div class="cart-total mb-3">
									<h3>Total Panier</h3>
									<p class="d-flex">
										<span>Sous total</span>
										<span>{{ Session::has('cart') ? Session::get('cart')->totalPrice : 0 }} €</span>
									</p>
									<p class="d-flex">
										<span>Expédition</span>
										<span>{{ $shippingCost ?? 0 }} €</span>
									</p>
									<hr>
									<p class="d-flex total-price">
										<span>Total</span>
										<span>{{ $totalPriceWithShipping ?? 0 }} €</span>
									</p>
								</div>
								@if (session('country_id') == null) <!-- Vérifie si le pays n'est pas défini -->
								<p><a href="#" class="btn btn-secondary py-3 px-4" disabled>Veuillez sélectionner un pays</a></p>
								<p class="alert alert-warning">Vous devez renseigner votre pays avant de valider la commande.</p>
								@else
								<p><a href="{{ url('/checkout') }}" class="btn btn-primary py-3 px-4">Valider la commande</a></p>
								@endif
							</div>
							
						</div>
						</div>
						</section>
						

@endsection

@section('scripts')
<script>
	$(document).ready(function(){

	var quantitiy=0;
	   $('.quantity-right-plus').click(function(e){
			
			// Stop acting like a button
			e.preventDefault();
			// Get the field name
			var quantity = parseInt($('#quantity').val());
			
			// If is not undefined
				
				$('#quantity').val(quantity + 1);

			  
				// Increment
			
		});

		 $('.quantity-left-minus').click(function(e){
			// Stop acting like a button
			e.preventDefault();
			// Get the field name
			var quantity = parseInt($('#quantity').val());
			
			// If is not undefined
		  
				// Increment
				if(quantity>0){
				$('#quantity').val(quantity - 1);
				}
		});
		
	});
</script>
@endsection
