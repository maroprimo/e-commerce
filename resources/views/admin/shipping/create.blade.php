@extends('layouts.appadmin')

@section('title')
    Ajouter Tarif Expedition
@endsection

@section('contenu')

        <div class="row grid-margin">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Ajouter tarif expédition</h4>
                  @if (Session::has('status'))
                        <div class="alert alert-success">
                          {{Session::get('status')}}

                        </div>
                      
                  @endif
                  <form action="{{ route('shipping.store') }}" method="POST" class='cmxform'>
                    @csrf
                    <div class="form-group">
                        <label for="country">Choisir le pays</label>
                        <select name="country_id" class="form-control" required>
                            <option value="">Sélectionner un pays</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="weight_min">Poids minimum (en grammes)</label>
                        <input type="number" step="0.001" name="weight_min" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="weight_max">Poids maximum (en grammes)</label>
                        <input type="number" step="0.001" name="weight_max" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Prix (€)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter Tarif</button>
                </form>
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