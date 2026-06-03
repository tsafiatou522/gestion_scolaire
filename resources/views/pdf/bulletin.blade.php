<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; }
        .header { text-align: center; border-bottom: 2px solid #1e3a5f; padding-bottom: 10px; margin-bottom: 16px; }
        .header h2 { color: #1e3a5f; margin: 0; font-size: 16px; }
        .title { text-align: center; font-size: 14px; font-weight: bold; color: #1e3a5f; margin: 12px 0; }
        .info-grid { display: flex; gap: 20px; margin-bottom: 16px; }
        .info-box { flex: 1; }
        .info-box table { width: 100%; border-collapse: collapse; }
        .info-box table td { padding: 4px 8px; border: 1px solid #ddd; font-size: 11px; }
        .info-box table td:first-child { background: #f0f4f8; font-weight: bold; width: 50%; }
        table.notes { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.notes th { background: #1e3a5f; color: #fff; padding: 6px 10px; text-align: center; }
        table.notes td { padding: 6px 10px; border: 1px solid #ddd; }
        table.notes tr:nth-child(even) td { background: #f8f9fa; }
        .moyenne-box { text-align: center; padding: 14px; background: #1e3a5f; color: #fff; border-radius: 6px; margin-bottom: 16px; }
        .moyenne-box .val { font-size: 28px; font-weight: bold; }
        .appreciation { text-align: center; font-size: 14px; font-weight: bold; margin-top: 4px; }
        .footer { margin-top: 40px; display: flex; justify-content: flex-end; }
        .signature { text-align: center; }
        .signature .line { border-top: 1px solid #222; width: 200px; margin: 40px auto 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>École Primaire — Bulletin de Notes</h2>
        <p>Année scolaire {{ $annee_scolaire }}</p>
    </div>

    <div class="title">BULLETIN DU TRIMESTRE {{ $trimestre }}</div>

    <div class="info-grid">
        <div class="info-box">
            <table>
                <tr><td>Nom et prénom</td><td>{{ $eleve->nom_complet }}</td></tr>
                <tr><td>Classe</td><td>{{ $eleve->classe->nom }}</td></tr>
                <tr><td>Niveau</td><td>{{ $eleve->classe->niveau }}</td></tr>
            </table>
        </div>
        <div class="info-box">
            <table>
                <tr><td>Rang</td><td>{{ $rang }} / {{ $effectif }}</td></tr>
                <tr><td>Effectif</td><td>{{ $effectif }} élèves</td></tr>
                <tr><td>Trimestre</td><td>{{ $trimestre }}</td></tr>
            </table>
        </div>
    </div>

    <table class="notes">
        <thead>
            <tr>
                <th style="text-align:left">Matière</th>
                <th>Coefficient</th>
                <th>Note / 20</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
            <tr>
                <td>{{ $note->matiere->nom }}</td>
                <td style="text-align:center">{{ $note->matiere->coefficient }}</td>
                <td style="text-align:center;font-weight:bold">{{ $note->note }}</td>
                <td style="text-align:center">{{ $note->note * $note->matiere->coefficient }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="display:flex; gap:20px; align-items:center; margin-bottom:16px;">
        <div class="moyenne-box" style="flex:1">
            <div>Moyenne générale</div>
            <div class="val">{{ $moyenne ?? '—' }} / 20</div>
        </div>
        @php
            $moy = $moyenne ?? 0;
            $app = match(true) {
                $moy >= 16 => 'Très bien',
                $moy >= 14 => 'Bien',
                $moy >= 12 => 'Assez bien',
                $moy >= 10 => 'Passable',
                default    => "Insuffisant — doit redoubler d'efforts",
            };
        @endphp
        <div style="flex:2; padding:14px; border:2px solid #1e3a5f; border-radius:6px; text-align:center;">
            <div style="color:#888; font-size:11px;">Appréciation</div>
            <div class="appreciation">{{ $app }}</div>
        </div>
    </div>

    <div class="footer">
        <div class="signature">
            <div class="line"></div>
            <div>Le Directeur</div>
        </div>
    </div>
</body>
</html>