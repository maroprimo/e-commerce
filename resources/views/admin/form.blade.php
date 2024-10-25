@extends('layouts.appadmin')

@section('title')

    Liste des catégories
    
@endsection

{{Form::hidden('', $increment=1)}}

@section('contenu')


      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Liste catégories</h4>
          @if (Session::has('status'))
          <div class="alert alert-success">
            {{Session::get('status')}}

          </div>
        
          @endif

          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="order-listing" class="table">

                        <h1>Mettre à jour le cours de l'euro</h1>
                    
                        @if (session('success'))
                            <div style="color: green;">{{ session('success') }}</div>
                        @endif
                    
                        <form action="{{ route('update.taux') }}" method="POST">
                            @csrf
                    
                            <label for="taux">Taux en euros :</label>
                            <input type="text" name="taux" id="taux" value="{{ $dernierTaux->taux ?? '' }}" required>
                    
                            <button type="submit">Mettre à jour</button>
                        </form>
                    
                        @if ($dernierTaux)
                            <p>Dernier taux : {{ $dernierTaux->taux }}</p>
                        @else
                            <p>Aucun taux disponible.</p>
                        @endif
                    
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
