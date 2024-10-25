@extends('layouts.app1')
@section('contenu')


{{--start content--}}
<section id="post-hero" class="hero" style="background-image: url('/storage/product_images/');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 text-center">
                <h1 class="mb-2">Blog art Epice</h1>
                <p>Les actualités de l'art en épices en Madagascar</p>
            </div>
        </div>
    </div>
</section>

<!-- Blog Post Content Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            
                                    
                @foreach ($articles as $article)
                <div class="col-md-4">

                    <div class="blog-entry">
                            
                        
                        <a href="/post/{{$article->id}}" class="img d-flex align-items-end" style="background-image: url('/storage/product_images/{{$article->image}}');">
                            <div class="overlay"></div>
                        </a>
                        <div class="text pt-3">
                            <h3><a href="/post/{{$article->id}}">{{$article->title}}</a></h3>
                            <p>{{$article->excerpt}}</p>
                            <p><a href="/post/{{$article->id}}" class="btn btn-primary">Lire la suite</a></p>
                        </div>
                        
                    </div>
                    
                </div>
                @endforeach 
                
            
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
                          <li><a href="/post/{{$dernierArticle->id}}">{{ $dernierArticle->title }}</a></li>
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
