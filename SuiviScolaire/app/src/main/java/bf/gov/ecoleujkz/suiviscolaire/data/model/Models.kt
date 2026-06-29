package bf.gov.ecoleujkz.suiviscolaire.data.model

data class LoginRequest(
    val email: String,
    val password: String
)

data class LoginResponse(
    val user: UserDto,
    val token: String
)

data class UserDto(
    val id: Int,
    val name: String,
    val email: String,
    val role: String
)

data class EleveDto(
    val id: Int,
    val nom_complet: String,
    val photo: String?,
    val classe: String?
)

data class DashboardDto(
    val id: Int,
    val nom: String,
    val prenom: String,
    val photo: String?,
    val classe: String?,
    val moyenne_generale: Double?,
    val rang: Int?,
    val dernieres_notes: List<DerniereNoteDto>
)

data class DerniereNoteDto(
    val matiere: String?,
    val note: Double,
    val note_max: Int,
    val trimestre: String?
)

data class NoteMatiereDto(
    val matiere: String,
    val trimestres: Map<String, TrimestreDto>
)

data class TrimestreDto(
    val notes: List<NoteValeurDto>,
    val moyenne: Double?
)

data class NoteValeurDto(
    val note: Double,
    val note_max: Int
)

data class PaiementsDto(
    val montant_total_du: Double,
    val montant_total_verse: Double,
    val reste_a_payer: Double,
    val statut: String,
    val historique: List<PaiementDto>
)

data class PaiementDto(
    val id: Int,
    val montant_verse: Double,
    val date_paiement: String?,
    val recu_pdf: String?,
    val observation: String?
)

data class AbsenceDto(
    val date: String?,
    val motif: String?,
    val justifiee: Boolean
)

data class AnnonceDto(
    val titre: String,
    val contenu: String,
    val type: String,
    val date: String?
)

data class UpdatePasswordRequest(
    val current_password: String,
    val new_password: String,
    val new_password_confirmation: String
)

data class MessageResponse(
    val message: String
)
