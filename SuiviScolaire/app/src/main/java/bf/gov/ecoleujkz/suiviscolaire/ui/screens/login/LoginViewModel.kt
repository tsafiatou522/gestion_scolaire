package bf.gov.ecoleujkz.suiviscolaire.ui.screens.login

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import bf.gov.ecoleujkz.suiviscolaire.data.repository.AuthRepository
import bf.gov.ecoleujkz.suiviscolaire.data.repository.AuthResult
import kotlinx.coroutines.launch

data class LoginUiState(
    val email: String = "",
    val password: String = "",
    val isLoading: Boolean = false,
    val errorMessage: String? = null,
    val isLoggedIn: Boolean = false
)

class LoginViewModel(private val authRepository: AuthRepository) : ViewModel() {

    var uiState by mutableStateOf(LoginUiState())
        private set

    fun onEmailChange(newEmail: String) {
        uiState = uiState.copy(email = newEmail, errorMessage = null)
    }

    fun onPasswordChange(newPassword: String) {
        uiState = uiState.copy(password = newPassword, errorMessage = null)
    }

    fun login() {
        if (uiState.email.isBlank() || uiState.password.isBlank()) {
            uiState = uiState.copy(errorMessage = "Veuillez remplir tous les champs.")
            return
        }

        uiState = uiState.copy(isLoading = true, errorMessage = null)

        viewModelScope.launch {
            val result = authRepository.login(uiState.email, uiState.password)
            uiState = when (result) {
                is AuthResult.Success -> uiState.copy(isLoading = false, isLoggedIn = true)
                is AuthResult.Error -> uiState.copy(isLoading = false, errorMessage = result.message)
            }
        }
    }
}
