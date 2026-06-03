<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; }
        .header { text-align: center; border-bottom: 2px solid #1e3a5f; padding-bottom: 12px; margin-bottom: 20px; }
        .header h2 { color: #1e3a5f; margin: 0; font-size: 16px; }
        .header p { margin: 2px 0; color: #555; }
        .title { text-align: center; font-size: 15px; font-weight: bold; margin: 16px 0; color: #1e3a5f; }
        .recu-num { text-align: right; color: #888; font-size: 11px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        table td { padding: 6px 10px; border: 1px solid #ddd; }
        table td:first-child { font-weight: bold; background: #f0f4f8; width: 40%; }
        .total-table td { font-size: 13px; }
        .total-row td { font-weight: bold; background: #1e3a5f; color: #fff; }
        .reste-row td { font-weight: bold; background: #fff3cd; color: #856404; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature { text-align: center; }
        .signature .line { border-top: 1px solid #222; width: 180px; margin: 40px auto 4px; }
        .watermark { color: #198754; font-weight: bold; font-size: 13px; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>École Primaire — Gestion de Scolarité</h2>
        <p>Ouagadougou, Burkina Faso</p>
    </div>

    <div class="title">REÇU DE PAIEMENT</div>
    <div class="recu-num">N° {{ str_pad($paiement->id, 5, '0', STR_PAD_LEFT) }} — {{ $paiement->date_paiement->format('d/m/Y') }}</div>

    <table>
        <tr><td>Nom de l'élève</td><td>{{ $eleve->nom_complet }}</td></tr>
        <tr><td>Classe</td><td>{{ $eleve->classe->nom }}</td></tr>
        <tr><td>Année scolaire</td><td>{{ $eleve->classe->annee_scolaire }}</td></tr>
        <tr><td>Nom du parent</td><td>{{ $eleve->nom_parent ?? '—' }}</td></tr>
        @if($paiement->observation)
        <tr><td>Observation</td><td>{{ $paiement->observation }}</td></tr>
        @endif
    </table>

    <table class="total-table">
        <tr>
            <td>Frais de scolarité total</td>
            <td>{{ number_format($montant_du, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <td>Versement du {{ $paiement->date_paiement->format('d/m/Y') }}</td>
            <td>{{ number_format($paiement->montant_verse, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <td>Total versé à ce jour</td>
            <td>{{ number_format($total_verse, 0, ',', ' ') }} FCFA</td>
        </tr>
        @if($reste > 0)
        <tr class="reste-row">
            <td>Reste à payer</td>
            <td>{{ number_format($reste, 0, ',', ' ') }} FCFA</td>
        </tr>
        @else
        <tr class="total-row">
            <td>Solde</td>
            <td>SOLDÉ ✓</td>
        </tr>
        @endif
    </table>

    @if($reste == 0)
    <div class="watermark">✓ PAIEMENT COMPLET — SOLDE À ZÉRO</div>
    @endif

    <div class="footer">
        <div class="signature">
            <div class="line"></div>
            <div>Le parent / tuteur</div>
        </div>
        <div class="signature">
            <div class="line"></div>
            <div>Le gestionnaire</div>
        </div>
    </div>
</body>
</html>