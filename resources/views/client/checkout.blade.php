@extends('layouts.app1')
@section('contenu')

    <div class="hero-wrap hero-bread" style="background-image: url('frontend/images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Checkout</span></p>
            <h1 class="mb-0 bread">Checkout</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-7 ftco-animate">

{{--			<form id="checkout-form" action="{{url('/payer')}}" method="POST">
				{{csrf_field()}}
				<h3 class="mb-4 billing-heading">Billing Details</h3>
				

		            		<label for="lastname">Name on Card</label>
		            		<input type="text" class="form-control" name="card-name" id="card-name">
		        
		            		<label for="lastname">Number</label>
		            		<input type="text" class="form-control" id="card-number" name="card-number">
		                
		            		<label for="lastname">Expiration Month</label>
		            		<input type="text" class="form-control" id="card-expiry-month" name="card-expiry-month">
		                
		            		<label for="lastname">Expiration anne</label>
		            		<input type="text" class="form-control" id="card-expiry-year" name="card-expiry-year">
		                
		            		<label for="lastname">CVC</label>
		            		<input type="text" class="form-control" id="card-cvc" name="card-cvc">
							<div id="card-element"></div>
		        
	          	         <div class="col-md-6">
		            	<div class="form-group">
		            		<input type="submit" class="btn btn-primary" value="Payer">
		                </div>
		            </div>
		        </div>

	          </form><!-- END -->

--}}	

{{--<form id="checkout-form" action="{{url('/payer')}}" method="POST">
    {{csrf_field()}}
{{--	<label for="lastname">Nom</label>
	<input type="text" class="form-control" name="name" id="name">

	<label for="lastname">Adresse</label>
	<input type="text" class="form-control" id="address" name="address">
    <div class="form-control" id="card-element"></div> <!-- Élément de carte Stripe -->
    <button type="submit" class="btn btn-primary">Payer</button>
    <div id="charge-error" class="hidden"></div> <!-- Zone d'erreur -->
</form>-------}}

<form id="checkout-form" action="{{url('/payer')}}" method="POST">
	{{csrf_field()}}

    <div class="form-group">
        <label for="address-line1">Nom</label>
        <input type="text" id="address-line1" name="nom" class="form-control" placeholder="Votre nom">
    </div>
    <div class="form-group">
        <label for="cardholder-name">Adresse</label>
        <input type="text" id="cardholder-name" name="adresse" class="form-control" placeholder="Adresse">
    </div>
    <div class="form-group">
        <label for="cardholder-name">Pays</label>
        <input type="text" id="cardholder-name" name="pays" class="form-control" placeholder="Pays">
    </div>
    <!-- Entrée du numéro de téléphone avec code pays -->
    <div class="form-group">
        <label for="phone_number">Numéro de téléphone (avec code pays)</label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="+33 6 11 22 33 44" pattern="^\+[0-9\s]*$" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Proceder au paiement</button>
    </div>
</form>

</div>
					<div class="col-xl-5">
	          <div class="row mt-5 pt-3">
	          	<div class="col-md-12 d-flex mb-5">
	          		<div class="cart-detail cart-total p-3 p-md-4">
	          			<h3 class="billing-heading mb-4">Total Panier</h3>
	          			<p class="d-flex">
		    						<span>Sous Total</span>
		    						<span>{{Session::get('cart')->totalPrice}} €</span>
		    					</p>
		    					<p class="d-flex">
		    						<span>Expédition</span>
		    						<span>{{ $shippingCost }} €</span>
		    					</p>
		    					<hr>
		    					<p class="d-flex total-price">
		    						<span>Total</span>
		    						<span>{{$totalPriceWithShipping}} €</span>
									
									
{{--
									<span> {{Session::get('cart')->totalQty}}</span>
									@if(Session::has('cart'))
    <div>
        @foreach(Session::get('cart')->items as $item)
            <span>{{ $item['product_name'] }} - Quantité: {{ $item['qty'] }}</span><br>
        @endforeach
    </div>
@else
    <p>Votre panier est vide.</p>
@endif--}}
		    					</p>
								</div>
	          	</div>
	          </div>
          </div> <!-- .col-md-8 -->
        </div>
      </div>
    </section> <!-- .section -->
@endsection


@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script src="src/js/checkout.js"></script>
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
