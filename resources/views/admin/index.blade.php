@extends('layouts.appadmin')

@section('title')

    Liste des articles
    
@endsection

@section('contenu')

{{Form::hidden('', $increment=1)}}

      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Liste des articles</h4>
          @if (Session::has('status'))
          <div class="alert alert-success">
            {{Session::get('status')}}

          </div>
        
          @endif
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="order-listing" class="table">
                  <thead>
                    <tr>
                        <th>Article #</th>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Image</th>
                        <th>Categories</th>
                        <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      @foreach ($articles as $article)
                      <td>{{$increment}}</td>
                      <td>{{$article->title}}</td>
                      <td>{{$article->excerpt}}</td>
                      <td><img src="/storage/product_images/{{$article->image}}" alt=""></td>
                      <td>{{$article->category_name}}</td>
                      <td>
                        @if ($article->status == 1)
                        <label class="badge badge-success">Activé</label>
                            
                        @else
                        <label class="badge badge-danger">Desactivé</label>    
                        @endif
                      </td>
                      <td>                          
                        <button class="btn btn-outline-primary" onclick="window.location ='{{url('/editarticle/'.$article->id)}}'">Edit</button>
                        <a href="{{url('/supprimerarticle/'.$article->id)}}" id="delete" class="btn btn-outline-danger">Delete</a>
                        @if ($article->status == 1)
                        <button class="btn btn-outline-warning" onclick="window.location ='{{url('/desactiver_produit/'.$article->id)}}'">Desactiver</button>    
                        @else
                        <button class="btn btn-outline-primary" onclick="window.location ='{{url('/activer_produit/'.$article->id)}}'">Activer</button>    
                        @endif
                      </td>
                  </tr>
                  {{Form::hidden('', $increment=$increment+1)}}         
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    
@endsection

@section('scripts')
    <script src="backend/js/data-table.js"></script>    
@endsection
