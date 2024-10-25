
@extends('layouts.appadmin')

@section('title')
    Editer Produit
@endsection

@section('contenu')

        <div class="row grid-margin">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Editer produit</h4>
                  @if (Session::has('status'))
                        <div class="alert alert-success">
                          {{Session::get('status')}}

                        </div>
                      
                  @endif

                  @if (count($errors)>0)
                      <div class="alert alert-danger">
                        <ul>
                          @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                          @endforeach                          
                        </ul>
                      </div>
                      
                  @endif
                    {!!Form::open(['action'=> 'ProductsController@modifierproduit', 'method'=>'POST', 'class'=>'cmxform', 'id'=>'commentForm', 'enctype'=>'multipart/form-data'])!!}
                    {{ csrf_field() }}
                      <div class="form-group">
                        {{Form::hidden('id', $produit->id)}}
                        {{Form::label('', 'Nom du produit', ['for'=>'cname'])}}
                        {{Form::text('product_name', $produit->product_name, ['class'=>'form-control', 'id'=>'cname'])}}
                      </div>
                      <div class="form-group">
                        {{Form::label('', 'Prix', ['for'=>'cname'])}}
                        {{--Form::number('product_price', $produit->product_price, ['class'=>'form-control', 'id'=>'cname'])--}}
                        <input type="number" step="0.001" value="{{$produit->product_price}}" name="product_price" class="form-control" required>
                      </div>
                      <div class="form-group">
                        {{Form::label('', 'Poids', ['for'=>'cname'])}}
                        {{--Form::number('weight', $produit->weight, ['class'=>'form-control', 'id'=>'cname'])--}}
                        <input type="number" step="0.001" value="{{$produit->weight}}" name="weight" class="form-control" required>
                      </div>
                        <div class="form-group">
                            {{Form::label('', 'Produit description')}}
                            {{Form::textarea('product_description', $produit->product_description, ['id'=> 'editor','placeholder' => 'Produit description', 'class' => 'form-control'])}}
                        </div>
                      <div class="form-group">
                        {{Form::label('', 'Catégories du produit')}}
                        {{Form::select('product_category', $categories, $produit->product_category, ['class'=>'form-control'])
                        }}
                      {{--
                        pour récupérer le $categories il faut faire $request->input('product_category'
                      --}}
                      <div class="form-group">
                        {{Form::label('', 'Image')}}
                        {{Form::file('product_image', ['class'=>'form-control', 'id'=>'cname'])}}
                      </div>
                      {{Form::submit('Modifier', ['class'=>'btn btn-primary'])}}
        
                  {!!Form::close()!!}
                </div>
              </div>
            </div>
          </div>
    
@endsection

@section('scripts')
  <!-- Custom js for this page--> 
{{--  <script src="backend/js/form-validation.js"></script>
  <script src="backend/js/bt-maxLength.js"></script>--}}
  <!-- End custom js for this page-->
   
@endsection