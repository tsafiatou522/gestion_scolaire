package bf.gov.ecoleujkz.suiviscolaire.ui.screens.annonces

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import bf.gov.ecoleujkz.suiviscolaire.data.model.AnnonceDto
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ApiResult
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository
import kotlinx.coroutines.launch

data class AnnoncesUiState(
    val isLoading: Boolean = true,
    val annonces: List<AnnonceDto> = emptyList(),
    val errorMessage: String? = null
)

class AnnoncesViewModel(private val repository: ParentRepository) : ViewModel() {

    var uiState by mutableStateOf(AnnoncesUiState())
        private set

    init {
        loadAnnonces()
    }

    fun loadAnnonces() {
        uiState = uiState.copy(isLoading = true, errorMessage = null)
        viewModelScope.launch {
            when (val result = repository.getAnnonces()) {
                is ApiResult.Success -> {
                    uiState = uiState.copy(isLoading = false, annonces = result.data)
                }
                is ApiResult.Error -> {
                    uiState = uiState.copy(isLoading = false, errorMessage = result.message)
                }
            }
        }
    }
}
