package bf.gov.ecoleujkz.suiviscolaire.data.repository

import bf.gov.ecoleujkz.suiviscolaire.data.model.AbsenceDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.AnnonceDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.DashboardDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.EleveDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.NoteMatiereDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.PaiementsDto
import bf.gov.ecoleujkz.suiviscolaire.data.network.ApiService

sealed class ApiResult<out T> {
    data class Success<T>(val data: T) : ApiResult<T>()
    data class Error(val message: String) : ApiResult<Nothing>()
}

class ParentRepository(private val apiService: ApiService) {

    suspend fun getEnfants(): ApiResult<List<EleveDto>> {
        return safeCall { apiService.getEnfants() }
    }

    suspend fun getDashboard(eleveId: Int): ApiResult<DashboardDto> {
        return safeCall { apiService.getDashboard(eleveId) }
    }

    suspend fun getNotes(eleveId: Int): ApiResult<List<NoteMatiereDto>> {
        return safeCall { apiService.getNotes(eleveId) }
    }

    suspend fun getPaiements(eleveId: Int): ApiResult<PaiementsDto> {
        return safeCall { apiService.getPaiements(eleveId) }
    }

    suspend fun getAbsences(eleveId: Int): ApiResult<List<AbsenceDto>> {
        return safeCall { apiService.getAbsences(eleveId) }
    }

    suspend fun getAnnonces(): ApiResult<List<AnnonceDto>> {
        return safeCall { apiService.getAnnonces() }
    }

    private suspend fun <T> safeCall(call: suspend () -> retrofit2.Response<T>): ApiResult<T> {
        return try {
            val response = call()
            if (response.isSuccessful && response.body() != null) {
                ApiResult.Success(response.body()!!)
            } else {
                ApiResult.Error("Erreur serveur (${response.code()}).")
            }
        } catch (e: Exception) {
            ApiResult.Error("Erreur de connexion. Verifiez votre reseau.")
        }
    }
}
