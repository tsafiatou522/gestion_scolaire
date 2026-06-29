package bf.gov.ecoleujkz.suiviscolaire.ui.screens.splash

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import androidx.lifecycle.viewModelScope
import bf.gov.ecoleujkz.suiviscolaire.data.repository.AuthRepository
import kotlinx.coroutines.launch

enum class SessionState {
    LOADING, LOGGED_IN, LOGGED_OUT
}

class SessionViewModel(private val authRepository: AuthRepository) : ViewModel() {

    var sessionState by mutableStateOf(SessionState.LOADING)
        private set

    init {
        viewModelScope.launch {
            sessionState = if (authRepository.isLoggedIn()) {
                SessionState.LOGGED_IN
            } else {
                SessionState.LOGGED_OUT
            }
        }
    }
}

class SessionViewModelFactory(private val authRepository: AuthRepository) : ViewModelProvider.Factory {
    @Suppress("UNCHECKED_CAST")
    override fun <T : ViewModel> create(modelClass: Class<T>): T {
        if (modelClass.isAssignableFrom(SessionViewModel::class.java)) {
            return SessionViewModel(authRepository) as T
        }
        throw IllegalArgumentException("ViewModel inconnu: ${modelClass.name}")
    }
}
