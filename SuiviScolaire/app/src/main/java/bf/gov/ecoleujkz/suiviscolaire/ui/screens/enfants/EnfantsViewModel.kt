package bf.gov.ecoleujkz.suiviscolaire.ui.screens.enfants

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import bf.gov.ecoleujkz.suiviscolaire.data.model.EleveDto
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ApiResult
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository
import kotlinx.coroutines.launch

data class EnfantsUiState(
    val isLoading: Boolean = true,
    val enfants: List<EleveDto> = emptyList(),
    val errorMessage: String? = null
)

class EnfantsViewModel(private val repository: ParentRepository) : ViewModel() {

    var uiState by mutableStateOf(EnfantsUiState())
        private set

    init {
        loadEnfants()
    }

    fun loadEnfants() {
        uiState = uiState.copy(isLoading = true, errorMessage = null)
        viewModelScope.launch {
            when (val result = repository.getEnfants()) {
                is ApiResult.Success -> {
                    uiState = uiState.copy(isLoading = false, enfants = result.data)
                }
                is ApiResult.Error -> {
                    uiState = uiState.copy(isLoading = false, errorMessage = result.message)
                }
            }
        }
    }
}
