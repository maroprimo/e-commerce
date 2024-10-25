@extends('layouts.app1')
@section('contenu')


{{--start content--}}
<section id="post-hero" class="hero" style="background-image: url('/storage/product_images/{{$article->image}}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 text-center">
                <h1 class="mb-2">{{$article->title}}</h1>
                <p>Posted {{$article->created_at}}, 2024 by Admin</p>
            </div>
        </div>
    </div>
</section>

<!-- Blog Post Content Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">
                <h2 class="mb-3">{{$article->title}}</h2>
                <p>
                    <img src="/storage/product_images/{{$article->image}}" class="img-fluid" alt=""> 
                {!!$article->content!!}

                <div class="tag-widget post-tag-container mb-5 mt-5">
                    <div class="tagcloud">
                        @foreach ($categories as $category)
                        <a href="#" class="tag-cloud-link">{{$category->name}}</a>    
                        @endforeach
                        
                    </div>
                </div>

                

                <div class="pt-5 mt-5">

                    <div class="comment-form-wrap pt-5">
                        <h3 class="mb-5">Leave a comment</h3>
                        <form action="#" class="p-5 bg-light">
                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Post Comment" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 sidebar">
                <div class="sidebar-box">
                    <form action="#" class="search-form">
                        <div class="form-group">
                            <span class="icon ion-ios-search"></span>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                    </form>
                </div>

                <div class="sidebar-box ftco-animate">
                    <h3 class="sidebar-heading">Categories</h3>
                    <ul class="categories">
                        @foreach ($categories as $category)
                        
                        <li><a href="#">{{$category->name}} <span>                     
                        </span></a></li>

                            
                        @endforeach
                    </ul>
                </div>

                <div class="sidebar-box ftco-animate">
                    <h3 class="sidebar-heading">Articles récent</h3>
                    <ul class="categories">
                        @foreach($dernierArticles as $dernierArticle)
                          <li><a href="#">{{ $dernierArticle->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
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
