<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Update</title>
</head>
<body>
    <h1>Bonjour {{ $order->nom }},</h1>
    <p>Votre commande #{{ $order->id }} est en cours de préparation.</p>
    <p>Merci pour votre patience !</p>
</body>
</html>
