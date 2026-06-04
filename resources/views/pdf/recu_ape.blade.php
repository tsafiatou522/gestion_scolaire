<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu Cotisation APE #{{ $cotisation->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 10px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #20c997;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .institution-name {
            font-size: 18px;
            font-weight: bold;
            color: #111;
            text-transform: uppercase;
        }
        .document-title {
            font-size: 22px;
            font-weight: bold;
            color: #20c997;
            text-align: right;
        }
        .info-box {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-box td {
            vertical-align: top;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .details-table th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .details-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .amount-box {
            background-color: #e8f5e9;
            border: 1px solid #a5d6a7;
            color: #2e7d32;
            font-size: 18px;
            font-weight: bold;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            margin-top: 20px;
        }
        .signatures {
            width: 100%;
            margin-top: 50px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            font-weight: bold;
        }
        .signature-space {
            margin-top: 60px;
            border-bottom: 1px dashed #ccc;
            width: 200px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="institution-name">{{ config('app.name', 'Gestion Scolaire') }}</div>
                <div style="color: #666; font-size: 12px; margin-top: 5px;">
                    Association des Parents d'Élèves (APE)<br>
                    Burkina Faso
                </div>
            </td>
            <td class="document-title">
                REÇU APE<br>
                <span style="font-size: 14px; color: #6c757d; font-weight: normal;">N° APE-{{ str_pad($cotisation->id, 5, '0', STR_PAD_LEFT) }}</span>
            </td>
        </tr>
    </table>

    <table class="info-box">
        <tr>
            <td style="width: 60%;">
                <strong>Date de paiement :</strong> {{ $cotisation->date_paiement->format('d/m/Y') }}<br>
                <strong>Année Scolaire :</strong> {{ $cotisation->annee_scolaire }}
            </td>
            <td style="width: 40%; text-align: right;">
                <strong>Généré le :</strong> {{ now()->format('d/m/Y à H:i') }}
            </td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th>Désignation / Motif</th>
                <th>Élève</th>
                <th>Classe</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Cotisation Annuelle APE</strong><br>
                    <span style="font-size: 12px; color: #777;">Contribution obligatoire au développement de l'établissement.</span>
                </td>
                <td style="text-transform: uppercase;">
                    {{ $cotisation->eleve->nom_complet ?? 'Inconnu' }}
                </td>
                <td>
                    {{ $cotisation->eleve->classe->nom ?? 'N/A' }}
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                @if($cotisation->observation)
                    <div style="font-size: 12px; color: #666; padding-right: 20px;">
                        <strong>Observation :</strong> {{ $cotisation->observation }}
                    </div>
                @endif
            </td>
            <td style="width: 50%;">
                <div class="amount-box">
                    Montant Versé : {{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA
                </div>
            </td>
        </tr>
    </table>

    <table class="signatures">
        <tr>
            <td>
                Le Parent / Déposant
                <br><div class="signature-space"></div>
            </td>
            <td>
                Le Trésorier / Agent de Recouvrement
                <br><div class="signature-space"></div>
            </td>
        </tr>
    </table>

    <div style="position: absolute; bottom: 20px; left: 0; right: 0; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 5px;">
        Ce document sert de preuve officielle de paiement de la cotisation APE. Conservé précieusement.
    </div>

</body>
</html>