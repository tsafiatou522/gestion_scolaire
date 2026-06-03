# Système de Gestion de Scolarité et de Notes

**Université Joseph Ki-Zerbo — UFR/SEA**  
Projet Web & Framework — Enseignant : Lionel Marcus G. KABORET

---

## Membres du groupe

| Nom & Prénom | Matricule |
|---|---|
| TOURE SAFIATOU | N00383920212 |
| _(à compléter)_ | _(à compléter)_ |

---

## Présentation

Application web de gestion d'un établissement d'enseignement primaire (CP1 au CM2).
Elle permet un suivi rigoureux des élèves, des paiements de scolarité et des notes.

## Fonctionnalités

- Authentification sécurisée avec 3 rôles (Directeur, Enseignant, Gestionnaire)
- Inscription des élèves avec photo
- Gestion des classes et frais de scolarité
- Enregistrement des paiements + reçu PDF automatique
- Saisie des notes + calcul automatique des moyennes
- Bulletins de notes PDF
- Tableau de bord complet avec graphiques
- Exportation Excel
- Recherche globale
- Notifications impayés

## Stack technique

| Composant | Technologie |
|---|---|
| Backend | PHP 8.x — Laravel 10.x |
| Base de données | MySQL 8 |
| ORM | Eloquent |
| Vues | Blade + Bootstrap 5 |
| Génération PDF | barryvdh/laravel-dompdf |
| Export Excel | maatwebsite/excel |

## Installation

```bash
git clone https://github.com/ton-username/gestion-scolaire.git
cd gestion-scolaire
composer install
cp .env.example .env
php artisan key:generate
```

Configurer `.env` :
```
DB_DATABASE=gestion_scolarite
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## Connexion par défaut

- **Email :** admin@ecole.bf
- **Mot de passe :** password
- **Rôle :** Directeur