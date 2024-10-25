@extends('layouts.appadmin')

@section('title')
    Ajouter pays
@endsection

@section('contenu')

        <div class="row grid-margin">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Ajouter pays</h4>
                  @if (Session::has('status'))
                        <div class="alert alert-success">
                          {{Session::get('status')}}

                        </div>
                      
                  @endif
                    {!!Form::open(['action'=> 'ShippingController@sauvepays', 'method'=>'POST', 'class'=>'cmxform', 'id'=>'commentForm'])!!}
                    {{ csrf_field() }}
                      <div class="form-group">
                        {{Form::label('', 'Nom du pays', ['for'=>'cname'])}}
                        {{Form::text('name', '', ['class'=>'form-control', 'id'=>'cname'])}}
                      </div>
                      {{Form::submit('Ajouter', ['class'=>'btn btn-primary'])}}
        
                  {!!Form::close()!!}
                </div>
              </div>
            </div>
          </div> 
    
@endsection

@section('scripts')
  <!-- Custom js for this page-->
  {{--<script src="backend/js/form-validation.js"></script>
  <script src="backend/js/bt-maxLength.js"></script>--}}
  <!-- End custom js for this page-->
   
@endsection