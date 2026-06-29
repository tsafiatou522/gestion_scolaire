package bf.gov.ecoleujkz.suiviscolaire.ui.navigation

object Routes {
    const val LOGIN = "login"
    const val ENFANTS = "enfants"
    const val DASHBOARD = "dashboard/{eleveId}"
    const val NOTES = "notes/{eleveId}"
    const val PAIEMENTS = "paiements/{eleveId}"
    const val ABSENCES = "absences/{eleveId}"
    const val ANNONCES = "annonces"

    fun dashboard(eleveId: Int) = "dashboard/$eleveId"
    fun notes(eleveId: Int) = "notes/$eleveId"
    fun paiements(eleveId: Int) = "paiements/$eleveId"
    fun absences(eleveId: Int) = "absences/$eleveId"
}
