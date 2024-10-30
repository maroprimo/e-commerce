<!-- resources/views/invoice.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-header, .invoice-footer { text-align: center; }
        .invoice-title { font-size: 24px; font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1 class="invoice-title">Facture</h1>
    </div>
    
    <div>
        <p><strong>Nom client:</strong> {{ $order->nom }}</p>
        <p><strong>Adresse:</strong> {{ $order->adresse }}</p>
        <p><strong>Pays:</strong> {{ $order->pays }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} €</td>
                <td>{{ number_format($item->quantity * $item->price, 2) }} €</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">{{ number_format($order->total_price, 2) }} €</td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-footer">
        <p>Merci pour votre achat !</p>
    </div>
</body>
</html>
