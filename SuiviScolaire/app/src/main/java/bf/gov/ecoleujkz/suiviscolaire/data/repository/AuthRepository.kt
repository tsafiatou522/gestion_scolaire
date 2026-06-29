package bf.gov.ecoleujkz.suiviscolaire.data.repository

import bf.gov.ecoleujkz.suiviscolaire.data.local.TokenManager
import bf.gov.ecoleujkz.suiviscolaire.data.model.LoginRequest
import bf.gov.ecoleujkz.suiviscolaire.data.network.ApiService

sealed class AuthResult {
    data class Success(val userName: String) : AuthResult()
    data class Error(val message: String) : AuthResult()
}

class AuthRepository(
    private val apiService: ApiService,
    private val tokenManager: TokenManager
) {

    suspend fun login(email: String, password: String): AuthResult {
        return try {
            val response = apiService.login(LoginRequest(email, password))

            if (response.isSuccessful && response.body() != null) {
                val body = response.body()!!
                tokenManager.saveToken(body.token)
                AuthResult.Success(body.user.name)
            } else {
                AuthResult.Error("Email ou mot de passe incorrect.")
            }
        } catch (e: Exception) {
            AuthResult.Error("Erreur de connexion. Verifiez votre reseau.")
        }
    }

    suspend fun logout() {
        try {
            apiService.logout()
        } catch (e: Exception) {
            // On efface le token localement meme si l'appel reseau echoue
        }
        tokenManager.clearToken()
    }

    suspend fun isLoggedIn(): Boolean {
        return !tokenManager.getTokenOnce().isNullOrEmpty()
    }
}
