package bf.gov.ecoleujkz.suiviscolaire.ui.screens.paiements

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import bf.gov.ecoleujkz.suiviscolaire.data.model.PaiementsDto
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ApiResult
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository
import kotlinx.coroutines.launch

data class PaiementsUiState(
    val isLoading: Boolean = true,
    val paiements: PaiementsDto? = null,
    val errorMessage: String? = null
)

class PaiementsViewModel(
    private val repository: ParentRepository,
    private val eleveId: Int
) : ViewModel() {

    var uiState by mutableStateOf(PaiementsUiState())
        private set

    init {
        loadPaiements()
    }

    fun loadPaiements() {
        uiState = uiState.copy(isLoading = true, errorMessage = null)
        viewModelScope.launch {
            when (val result = repository.getPaiements(eleveId)) {
                is ApiResult.Success -> {
                    uiState = uiState.copy(isLoading = false, paiements = result.data)
                }
                is ApiResult.Error -> {
                    uiState = uiState.copy(isLoading = false, errorMessage = result.message)
                }
            }
        }
    }
}
