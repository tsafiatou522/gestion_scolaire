package bf.gov.ecoleujkz.suiviscolaire.data.network

import bf.gov.ecoleujkz.suiviscolaire.data.model.AbsenceDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.AnnonceDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.DashboardDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.EleveDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.LoginRequest
import bf.gov.ecoleujkz.suiviscolaire.data.model.LoginResponse
import bf.gov.ecoleujkz.suiviscolaire.data.model.MessageResponse
import bf.gov.ecoleujkz.suiviscolaire.data.model.NoteMatiereDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.PaiementsDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.UpdatePasswordRequest
import retrofit2.Response
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.PUT
import retrofit2.http.POST
import retrofit2.http.Path

interface ApiService {

    @POST("login")
    suspend fun login(@Body request: LoginRequest): Response<LoginResponse>

    @POST("logout")
    suspend fun logout(): Response<MessageResponse>

    @PUT("password")
    suspend fun updatePassword(@Body request: UpdatePasswordRequest): Response<MessageResponse>

    @GET("enfants")
    suspend fun getEnfants(): Response<List<EleveDto>>

    @GET("eleves/{eleveId}/dashboard")
    suspend fun getDashboard(@Path("eleveId") eleveId: Int): Response<DashboardDto>

    @GET("eleves/{eleveId}/notes")
    suspend fun getNotes(@Path("eleveId") eleveId: Int): Response<List<NoteMatiereDto>>

    @GET("eleves/{eleveId}/paiements")
    suspend fun getPaiements(@Path("eleveId") eleveId: Int): Response<PaiementsDto>

    @GET("eleves/{eleveId}/absences")
    suspend fun getAbsences(@Path("eleveId") eleveId: Int): Response<List<AbsenceDto>>

    @GET("annonces")
    suspend fun getAnnonces(): Response<List<AnnonceDto>>
}
