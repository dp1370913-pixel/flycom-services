<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document {{ $devis->numero }}</title>
    <style>
        body { font-family: sans-serif; color: #333; font-size: 11px; margin: 10px; }
        .header { width: 100%; border-bottom: 2px solid #0D1B4B; padding-bottom: 10px; margin-bottom: 25px; }
        .title { font-size: 18px; color: #0D1B4B; font-weight: bold; }
        .details-table { width: 100%; margin-bottom: 25px; }
        .details-table td { width: 50%; vertical-align: top; }
        .table-items { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .table-items th { background-color: #F8FAFC; border: 1px solid #E2E8F0; padding: 6px; font-weight: bold; font-size: 10px; }
        .table-items td { border: 1px solid #E2E8F0; padding: 6px; }
        .totals { float: right; width: 45%; text-align: right; margin-top: 10px; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .text-navy { color: #0D1B4B; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <span class="title">FLYCOM SERVICES</span><br>
                    <span>22, Avenue de Brazza — La Glacière, Brazzaville</span><br>
                    <span>Tél : 06 628 57 41 / 04 411 80 78</span>
                </td>
                <td class="text-end" style="vertical-align: bottom;">
                    <strong style="font-size: 13px; text-transform: uppercase; color: #666;">{{ str_replace('_', ' ', $devis->type) }}</strong><br>
                    <strong style="font-size: 14px;" class="text-navy">{{ $devis->numero }}</strong>
                </td>
            </tr>
        </table>
    </div>

    <table class="details-table">
        <tr>
            <td>
                <span style="color: #666; text-transform: uppercase; font-size: 9px; display: block; margin-bottom: 3px;">Émetteur</span><br>
                <strong>Flycom Services</strong><br>
                <span>Département Facturation &amp; Devis</span>
            </td>
            <td class="text-end">
                <span style="color: #666; text-transform: uppercase; font-size: 9px; display: block; margin-bottom: 3px;">Destinataire</span><br>
                <strong>{{ $devis->client->prenom }} {{ $devis->client->nom }}</strong><br>
                <span>{{ $devis->client->entreprise ?? 'Particulier' }}</span><br>
                <span>{{ $devis->client->telephone }}</span>
            </td>
        </tr>
    </table>

    <div style="background-color: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px; margin-bottom: 25px;">
        <table style="width: 100%; font-size: 10px;">
            <tr>
                <td><strong>Date d'émission :</strong> {{ \Carbon\Carbon::parse($devis->date_emission)->format('d/m/Y') }}</td>
                <td class="text-end"><strong>Date d'échéance :</strong> {{ \Carbon\Carbon::parse($devis->date_expiration)->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="table-items">
        <thead>
            <tr>
                <th style="text-align: left; width: 50%;">Désignation</th>
                <th style="width: 10%;">Qté</th>
                <th class="text-end" style="width: 20%;">Prix unitaire</th>
                <th class="text-end" style="width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devis->services as $service)
            <tr>
                <td>
                    <strong class="text-navy">{{ $service->pivot->nom_service_snapshot }}</strong><br>
                    <span style="color: #666; font-size: 9px;">{{ $service->pivot->description_snapshot }}</span>
                </td>
                <td class="text-center">{{ $service->pivot->quantite }}</td>
                <td class="text-end">{{ number_format($service->pivot->prix_unitaire, 0, ',', ' ') }} F</td>
                <td class="text-end">{{ number_format($service->pivot->quantite * $service->pivot->prix_unitaire, 0, ',', ' ') }} F</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table style="width: 100%;">
            <tr>
                <td style="color: #666; font-weight: bold;">Total Hors Taxes :</td>
                <td class="text-end"><strong>{{ number_format($devis->montant_ht, 0, ',', ' ') }} FCFA</strong></td>
            </tr>
            <tr>
                <td style="color: #666; font-weight: bold; padding-top: 5px;">TVA :</td>
                <td class="text-end" style="padding-top: 5px;"><strong>{{ number_format($devis->tva, 0, ',', ' ') }} FCFA</strong></td>
            </tr>
            <tr style="font-size: 13px;">
                <td class="text-navy" style="font-weight: bold; padding-top: 10px; border-top: 1px solid #E2E8F0;">Total TTC :</td>
                <td class="text-navy text-end" style="font-weight: bold; padding-top: 10px; border-top: 1px solid #E2E8F0;">{{ number_format($devis->montant_ttc, 0, ',', ' ') }} FCFA</td>
            </tr>
        </table>
    </div>
</body>
</html>