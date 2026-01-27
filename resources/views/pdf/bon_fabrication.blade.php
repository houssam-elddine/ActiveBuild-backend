<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bon de Fabrication</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 14px; }
        .box { border:1px solid #000; padding:10px; margin-bottom:15px; }
        table { width:100%; border-collapse:collapse; }
        th, td { border:1px solid #000; padding:8px; text-align:center; }
    </style>
</head>
<body>

<h2 align="center">BON DE FABRICATION</h2>

<div class="box">
    <strong>Commande #{{ $bon->commande->id }}</strong><br>
    Date : {{ $bon->created_at->format('d/m/Y') }}
</div>

<div class="box">
    <strong>Client</strong><br>
    Nom : {{ $bon->commande->devis->name }}<br>
    Téléphone : {{ $bon->commande->devis->phone }}
</div>

<table>
    <tr>
        <th>Type</th>
        <th>Hauteur</th>
        <th>Largeur</th>
        <th>Quantité</th>
    </tr>
    <tr>
        <td>{{ $bon->commande->devis->type }}</td>
        <td>{{ $bon->commande->devis->hauteur }}</td>
        <td>{{ $bon->commande->devis->largeur }}</td>
        <td>{{ $bon->commande->devis->quantite }}</td>
    </tr>
</table>

<div class="box">
    <strong>Étapes de fabrication :</strong><br>
    {{ $bon->etapes }}
</div>

<p align="center">Signature Atelier ____________________</p>

</body>
</html>
