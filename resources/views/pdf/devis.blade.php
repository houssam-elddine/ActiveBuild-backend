<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devis #{{ $devis->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>DEVIS</h2>
        <p>Référence : DEV-{{ $devis->id }}</p>
        <p>Date : {{ $devis->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="box">
        <strong>Client :</strong><br>
        Nom : {{ $devis->name }} <br>
        Téléphone : {{ $devis->phone }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Hauteur</th>
                <th>Largeur</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $devis->type }}</td>
                <td>{{ $devis->hauteur }}</td>
                <td>{{ $devis->largeur }}</td>
                <td>{{ $devis->quantite }}</td>
            </tr>
        </tbody>
    </table>

    <div class="box">
        <strong>Statut :</strong> {{ strtoupper($devis->status) }}
    </div>

    <div class="footer">
        <p>Merci pour votre confiance</p>
        <p>Société PVC & Aluminium</p>
    </div>

</body>
</html>
