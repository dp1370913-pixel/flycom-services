<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $devis->numero }} - Impression Facture | Flycom Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fff; color: #000; padding: 20px; }
        .invoice-title { font-weight: 800; color: #0D1B4B; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="container max-w-lg my-4">
        <!-- En-tête -->
        <div class="row justify-content-between align-items-center mb-5 pb-3 border-bottom">
            <div class="col-6">
                <h1 class="invoice-title h3 mb-1">FLYCOM SERVICES</h1>
                <p class="text-muted fs-8 mb-0">22, Avenue de Brazza — La Glacière, Brazzaville</p>
                <small class="text-muted d-block">Tél : 06 628 57 41 / 04 411 80 78</small>
            </div>
            <div class="col-6 text-end">
                <h2 class="h5 fw-bold text-uppercase text-muted mb-1">{{ str_replace('_', ' ', $devis->type) }}</h2>
                <h3 class="h4 fw-extrabold text-navy mb-0">{{ $devis->numero }}</h3>
            </div>
        </div>

        <!-- Coordonnées Client -->
        <div class="row mb-5 justify-content-between">
            <div class="col-6">
                <span class="text-uppercase text-muted fs-9 d-block mb-1">Émetteur</span>
                <strong class="d-block">Flycom Services</strong>
                <span class="text-muted fs-8">Département Facturation &amp; Devis</span>
            </div>
            <div class="col-6 text-end">
                <span class="text-uppercase text-muted fs-9 d-block mb-1">Destinataire</span>
                <strong class="d-block">{{ $devis->client->prenom }} {{ $devis->client->nom }}</strong>
                <span class="text-muted fs-8 d-block">{{ $devis->client->entreprise ?? 'Particulier' }}</span>
                <span class="text-muted fs-8 d-block">{{ $devis->client->telephone }}</span>
            </div>
        </div>

        <!-- Dates -->
        <div class="p-3 rounded-3 mb-5 d-flex justify-content-between fs-8" style="background:#F8FAFC; border:1px solid #E2E8F0;">
            <span><strong>Date d'émission :</strong> {{ \Carbon\Carbon::parse($devis->date_emission)->format('d/m/Y') }}</span>
            <span><strong>Date d'échéance :</strong> {{ \Carbon\Carbon::parse($devis->date_expiration)->format('d/m/Y') }}</span>
        </div>

        <!-- Lignes d'articles -->
        <h4 class="h6 fw-bold text-uppercase text-muted mb-3">Détail des prestations</h4>
        <table class="table table-bordered align-middle fs-8 mb-4">
            <thead class="table-light text-center">
                <tr>
                    <th scope="col" class="text-start" style="width: 50%;">Désignation</th>
                    <th scope="col" style="width: 10%;">Qté</th>
                    <th scope="col" class="text-end" style="width: 20%;">Prix unitaire</th>
                    <th scope="col" class="text-end" style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devis->services as $service)
                <tr>
                    <td>
                        <strong class="text-navy d-block">{{ $service->pivot->nom_service_snapshot }}</strong>
                        <small class="text-muted d-block fs-10" style="line-height:1.2;">{{ $service->pivot->description_snapshot }}</small>
                    </td>
                    <td class="text-center fw-semibold">{{ $service->pivot->quantite }}</td>
                    <td class="text-end text-muted">{{ number_format($service->pivot->prix_unitaire, 0, ',', ' ') }} F</td>
                    <td class="text-end fw-bold text-navy">{{ number_format($service->pivot->quantite * $service->pivot->prix_unitaire, 0, ',', ' ') }} F</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totaux -->
        <div class="row justify-content-end text-end mb-5">
            <div class="col-md-5 fs-8">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted fw-semibold">Total Hors Taxes :</span>
                    <span class="fw-bold">{{ number_format($devis->montant_ht, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="d-flex justify-content-between border-top pt-2" style="font-size: 1.15rem;">
                    <span class="fw-bold">Total TTC :</span>
                    <span class="fw-extrabold text-navy">{{ number_format($devis->montant_ttc, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        <!-- Mentions et Bouton d'impression -->
        <div class="text-center mt-5 pt-3 border-top no-print">
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 py-2 fw-bold fs-8"><i class="bi bi-printer me-2"></i> Lancer l'impression PDF</button>
        </div>
    </div>

    <!-- Déclenchement automatique de l'impression -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>