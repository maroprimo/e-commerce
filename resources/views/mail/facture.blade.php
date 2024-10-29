<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        .email-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 600px;
        }
        .email-header {
            background-color: #587AA3;
            color: white;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            font-size: 14px;
            line-height: 1.5;
        }
        .email-footer {
            padding-top: 10px;
            font-size: 12px;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-content">
            <div class="email-header">
                <h1>Merci pour votre commande</h1>
            </div>
            <div class="email-body">
                <p>Bonjour {{$order->nom}},</p>
                <p>Votre commande a été bien reçu, un ticket de paiement vous sera envoyé par email d'ici peu, que vous pourriez régler par CB.</p>
                <p>Cordialement</p>
                <p><strong>[Commande {{$order->payment_id}}] ({{$order->created_at}})</strong></p>
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix U</th>
                            <th>Prix</th>
                        </tr>
                    </thead>
                     <tbody>
                        <tr>
                    <td>
                        @foreach ($order->items as $item)
                            {{ $item->product_name }} <br>
                        @endforeach</td>
                        <td>
                            @foreach ($order->items as $item)
                            {{ $item->quantity}}<br>
                            @endforeach</td>
                        <td>@foreach ($order->items as $item)
                            {{$item->price }} €<br>
                            @endforeach</td>
                        <td>
                            @foreach ($order->items as $item)
                            {{ $item->quantity * $item->price }} €<br>
                            @endforeach
                        </td>
                        </tr>
                    </tbody>
                </table>
                <table class="summary-table">
                    <tr>
                        <td class="label">Sous-total :</td>
                        <td class="value">{{$totalPriceSimple}} €</td>
                    </tr>
                    <tr>
                        <td class="label">Frais d'expédition :</td>
                        <td class="value">{{ $shippingCost }} €</td>
                    </tr>
                    <tr>
                        <td class="label">Total en Euro:</td>
                        <td class="value">{{ $order->total_price }} €</td>
                    </tr>
                    <tr>
                        <td class="label">Total en Ariary:</td>
                        <?php 
                       $totalAriary = $order->total_price * $coursEuro->taux;
                       ?>
                        <td class="value">Ar {{$totalAriary}}</td>
                    </tr>
                </table>

                <div class="billing-address">
                    <h3>Adresse de livraison</h3>
                    <div class="address-details">
                        <p>{{$order->nom}}<br>
                        {{$order->adresse}}<br>
                        {{$order->pays}}<br>
                        {{$order->phone_number}}<br>
                        <a href="mailto:{{Session::get('client')->email}}">{{Session::get('client')->email}}</a></p>
                    </div>
                </div>
            </div>
            <div class="email-footer">
                <p>Merci pour votre confiance.</p>
            </div>
        </div>
    </div>
</body>
</html>