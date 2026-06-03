<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; }
        .header { text-align: center; border-bottom: 2px solid #1e3a5f; padding-bottom: 12px; margin-bottom: 20px; }
        .header h2 { color: #1e3a5f; margin: 0; font-size: 16px; }
        .header h3 { color: #198754; margin: 4px 0 0; font-size: 13px; }
        .header p { margin: 2px 0; color: #555; }
        .title { text-align: center; font-size: 15px; font-weight: bold; margin: 16px 0; color: #198754; }
        .recu-num { text-align: right; color: #888; font-size: 11px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        table td { padding: 6px 10px; border: 1px solid #ddd; }
        table td:first-child { font-weight: bold; background: #f0f8f4; width: 40%; }
        .montant-row td { font-size: 15px; font-weight: bold; background: #198754; color: #fff; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature { text-align: center; }
        .signature .line { border-top: 1px solid #222; width: 180px; margin: 40px auto 4px; }
        .watermark { color: #198754; font-weight: bold; font-size: 13px; text-align: center; margin-top: 20px; border: 2px solid #198754; padding: 8px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>École Primaire — Gestion de Scolarité</h2>
        <h3>Association des Parents d'Élèves (APE)</h3>
        <p>Ouagadougou, Burkina Faso</p>
    </div>

    <div class="title">REÇU DE COTISATION APE</div>
    <div class="recu-num">
        N° APE-{{ str_pad($cotisation->id, 4, '0', STR_PAD_LEFT) }}
        — {{ $cotisation->date_paiement->format('d/m/Y') }}
    </div>

    <table>
        <tr><td>Nom de l'élève</td><td>{{ $cotisation->eleve->nom_complet }}</td></tr>
        <tr><td>Classe</td><td>{{ $cotisation->eleve->classe->nom }}</td></tr>
        <tr><td>Année scolaire</td><td>{{ $cotisation->annee_scolaire }}</td></tr>
        <tr><td>Nom du parent</td><td>{{ $cotisation->eleve->nom_parent ?? '—' }}</td></tr>
        <tr><td>Téléphone</td><td>{{ $cotisation->eleve->telephone_parent ?? '—' }}</td></tr>
        @if($cotisation->observation)
        <tr><td>Observation</td><td>{{ $cotisation->observation }}</td></tr>
        @endif
    </table>

    <table>
        <tr class="montant-row">
            <td>Montant de la cotisation APE</td>
            <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <td>Date du paiement</td>
            <td>{{ $cotisation->date_paiement->format('d/m/Y') }}</td>
        </tr>
    </table>

    <div class="watermark">
        ✓ COTISATION APE REÇUE — MERCI POUR VOTRE CONTRIBUTION
    </div>

    <div class="footer">
        <div class="signature">
            <div class="line"></div>
            <div>Le parent / tuteur</div>
        </div>
        <div class="signature">
            <div class="line"></div>
            <div>Le Trésorier APE</div>
        </div>
        <div class="signature">
            <div class="line"></div>
            <div>Le Directeur</div>
        </div>
    </div>
</body>
</html>