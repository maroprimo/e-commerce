@extends('layouts.appadmin')

@section('title')

    Commandes clients
    
@endsection
{{Form::hidden('', $increment=1)}}
@section('contenu')



      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Commandes</h4>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="order-listing" class="table">
                  <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Nom client</th>
                        <th>Status</th>
                        <th>Adresse</th>
                        <th>Pays</th>
                        <th>Email</th>
                        <th>Articles</th>
                        <th>P.U</th>
                        <th>ID Commande</th>
                        <th>Total</th>
                        <th>Detail</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $order)
                    <tr>
                      <td>{{ $order->id }}</td>
                      <td>{{ $order->nom }}</td>
                      <td>{{ $order->status }}</td>
                      <td>{{ $order->adresse }}</td>
                      <td>{{ $order->pays }}</td>
                      <td>{{ $order->email }}</td>
                      <td>
                      @foreach ($order->items as $item)
                      #{{ $item->product_name }} : {{ $item->quantity }}<br>
                      @endforeach
                      </td>
                    <td>
                      @foreach ($order->items as $item)
                      {{ $item->quantity * $item->price }} €<br>
                      @endforeach
                    </td>
                      <td>{{ $order->payment_id }}</td>
                      <td>{{ $order->total_price }} €</td>
                      <td>                          
                        <button class="btn btn-outline-primary" onclick="window.location ='{{ url('/generatePdf/' . $order->id) }}'">Telecharger</button>
                        <form action="{{ route('admin.deleteOrder', $order->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                        <form action="{{ route('admin.sendOrderEmail', $order->id) }}" method="POST" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn btn-info">Traiter</button>
                        </form>
                        <form action="{{ route('admin.sendOrderProcessedEmail', $order->id) }}" method="POST" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn btn-success">Valider</button>
                      </form>
                      </td>
                  </tr>
                    @endforeach

                  </tbody>
                </table>
                <div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection

@section('scripts')
    <script src="backend/js/data-table.js"></script>    
@endsection
