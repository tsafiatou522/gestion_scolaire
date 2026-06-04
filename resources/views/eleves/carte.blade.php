@extends('layouts.app')

@section('title', 'Carte scolaire')

@push('styles')
<style>
/* Style de la carte */
.carte-scolaire {
    width: 85.6mm;
    height: 54mm;
    border-radius: 10px;
    border: 2px solid #0d6efd;
    background: white;
    display: flex;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    margin: 40px auto;
}

.carte-gauche {
    width: 35%;
    background: linear-gradient(180deg, #0d6efd, #0a58ca);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 8px;
    gap: 6px;
}

.carte-gauche .logo-ecole {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.carte-gauche .nom-ecole {
    color: white;
    font-size: 7px;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
    line-height: 1.2;
}

.carte-gauche .photo-eleve {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}

.carte-gauche .photo-placeholder {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border: 2px solid white;
    background: rgba(255,255,255,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: white;
    font-weight: bold;
}

.carte-droite {
    width: 65%;
    padding: 8px 10px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.carte-droite .titre {
    text-align: center;
    font-size: 9px;
    font-weight: bold;
    color: #0d6efd;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 1px solid #0d6efd;
    padding-bottom: 3px;
}

.carte-droite .annee {
    text-align: center;
    font-size: 7px;
    color: #666;
    margin-bottom: 4px;
}

.carte-droite .infos {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.carte-droite .info-ligne {
    display: flex;
    font-size: 7.5px;
    line-height: 1.4;
}

.carte-droite .info-label {
    font-weight: bold;
    color: #333;
    width: 45%;
    min-width: 45%;
}

.carte-droite .info-valeur {
    color: #555;
}

.carte-droite .pied {
    text-align: center;
    font-size: 6px;
    color: #0d6efd;
    border-top: 1px solid #eee;
    padding-top: 3px;
    font-style: italic;
}

@media print {
    .sidebar,
    .bg-white.border-bottom,
    .no-print {
        display: none !important;
    }

    body {
        background: white !important;
        margin: 0 !important;
    }

    .d-flex {
        display: block !important;
    }

    .main-content, .p-4 {
        padding: 0 !important;
        margin: 0 !important;
    }

    .container {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .carte-scolaire {
        margin: 10mm auto !important;
        box-shadow: none !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    @page {
        size: A4;
        margin: 10mm;
    }
}
</style>
@endpush

@section('content')

<div class="container">

    {{-- Boutons cachés à l'impression --}}
    <div class="d-flex justify-content-between mb-3 no-print">
        <a href="{{ route('eleves.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer me-1"></i> Imprimer
        </button>
    </div>

    {{-- CARTE SCOLAIRE --}}
    <div class="carte-scolaire">

        {{-- Colonne gauche : logo + photo --}}
        <div class="carte-gauche">
            <div class="logo-ecole">🏫</div>
            <div class="nom-ecole">École<br>Primaire</div>

            @if($eleve->photo)
                <img src="{{ asset('storage/'.$eleve->photo) }}"
                     class="photo-eleve" alt="Photo">
            @else
                <div class="photo-placeholder">
                    {{ strtoupper(substr($eleve->prenom,0,1)) }}
                </div>
            @endif
        </div>

        {{-- Colonne droite : infos --}}
        <div class="carte-droite">
            <div>
                <div class="titre">Carte Scolaire</div>
                <div class="annee">Année scolaire {{ date('Y') }} - {{ date('Y') + 1 }}</div>
            </div>

            <div class="infos">
                <div class="info-ligne">
                    <span class="info-label">Nom :</span>
                    <span class="info-valeur">{{ $eleve->nom }}</span>
                </div>
                <div class="info-ligne">
                    <span class="info-label">Prénom :</span>
                    <span class="info-valeur">{{ $eleve->prenom }}</span>
                </div>
                <div class="info-ligne">
                    <span class="info-label">Classe :</span>
                    <span class="info-valeur">{{ $eleve->classe->nom ?? '-' }}</span>
                </div>
                <div class="info-ligne">
                    <span class="info-label">Sexe :</span>
                    <span class="info-valeur">{{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}</span>
                </div>
                <div class="info-ligne">
                    <span class="info-label">Né(e) le :</span>
                    <span class="info-valeur">{{ $eleve->date_naissance->format('d/m/Y') }}</span>
                </div>
                <div class="info-ligne">
                    <span class="info-label">Parent :</span>
                    <span class="info-valeur">{{ $eleve->nom_parent }}</span>
                </div>
                <div class="info-ligne">
                    <span class="info-label">Tél :</span>
                    <span class="info-valeur">{{ $eleve->telephone_parent }}</span>
                </div>
            </div>

            <div class="pied">Gestion Scolaire — École Primaire Joseph Ki-Zerbo</div>
        </div>

    </div>

</div>

@endsection