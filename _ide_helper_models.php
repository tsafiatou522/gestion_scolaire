<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $action
 * @property string|null $details
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereUserId($value)
 */
	class Activity extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eleve_id
 * @property int $montant
 * @property string $date_paiement
 * @property string $annee_scolaire
 * @property string|null $observation
 * @property string|null $recu_pdf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Eleve $eleve
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation whereAnneeScolaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation whereDatePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation whereEleveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation whereRecuPdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeCotisation whereUpdatedAt($value)
 */
	class ApeCotisation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string|null $telephone
 * @property string|null $email
 * @property string $fonction
 * @property int|null $eleve_id
 * @property string $annee_scolaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Eleve|null $eleve
 * @property-read string $fonction_label
 * @property-read string $nom_complet
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre whereAnneeScolaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre whereEleveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre whereFonction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApeMembre whereUpdatedAt($value)
 */
	class ApeMembre extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string $niveau
 * @property string $annee_scolaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Eleve> $eleves
 * @property-read int|null $eleves_count
 * @property-read \App\Models\FraisScolarite|null $fraisScolarite
 * @property-read int $nb_eleves
 * @property-read float $total_attendu
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Matiere> $matieres
 * @property-read int|null $matieres_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classe whereAnneeScolaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classe whereNiveau($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classe whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classe whereUpdatedAt($value)
 */
	class Classe extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property \Illuminate\Support\Carbon $date_naissance
 * @property string $sexe
 * @property string|null $photo
 * @property string|null $nom_parent
 * @property string|null $telephone_parent
 * @property int $classe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Classe $classe
 * @property-read float $montant_du
 * @property-read string $nom_complet
 * @property-read float $reste_a_payer
 * @property-read string $statut_paiement
 * @property-read float $total_verse
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Paiement> $paiements
 * @property-read int|null $paiements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve whereNomParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve whereTelephoneParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Eleve whereUpdatedAt($value)
 */
	class Eleve extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $classe_id
 * @property numeric $montant
 * @property string $annee_scolaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Classe $classe
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FraisScolarite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FraisScolarite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FraisScolarite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FraisScolarite whereAnneeScolaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FraisScolarite whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FraisScolarite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FraisScolarite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FraisScolarite whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FraisScolarite whereUpdatedAt($value)
 */
	class FraisScolarite extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $utilisateur
 * @property string $action
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historique newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historique query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historique whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historique whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historique whereUtilisateur($value)
 */
	class Historique extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nom
 * @property string|null $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Classe|null $classe
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Note> $notes
 * @property-read int|null $notes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereUpdatedAt($value)
 */
	class Matiere extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eleve_id
 * @property int $matiere_id
 * @property numeric $note
 * @property string $trimestre
 * @property string $annee_scolaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Eleve $eleve
 * @property-read \App\Models\Matiere|null $matiere
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereAnneeScolaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereEleveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereMatiereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereTrimestre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereUpdatedAt($value)
 */
	class Note extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eleve_id
 * @property float $montant_verse
 * @property \Illuminate\Support\Carbon $date_paiement
 * @property string|null $recu_pdf
 * @property string|null $observation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Eleve $eleve
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereDatePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereEleveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereMontantVerse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereRecuPdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereUpdatedAt($value)
 */
	class Paiement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

