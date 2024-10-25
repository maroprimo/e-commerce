
<div class="container">
    <h1>Liste des tarifs d'expédition</h1>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Pays</th>
                <th>Poids Min (g)</th>
                <th>Poids Max (g)</th>
                <th>Prix (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shippingRates as $rate)
            <tr>
                <td>{{ $rate->country->name }}</td>
                <td>{{ $rate->weight_min }}</td>
                <td>{{ $rate->weight_max }}</td>
                <td>{{ $rate->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

