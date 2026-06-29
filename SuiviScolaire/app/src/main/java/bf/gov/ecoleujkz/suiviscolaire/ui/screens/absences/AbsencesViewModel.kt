package bf.gov.ecoleujkz.suiviscolaire.ui.screens.absences

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import bf.gov.ecoleujkz.suiviscolaire.data.model.AbsenceDto
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ApiResult
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository
import kotlinx.coroutines.launch

data class AbsencesUiState(
    val isLoading: Boolean = true,
    val absences: List<AbsenceDto> = emptyList(),
    val errorMessage: String? = null
)

class AbsencesViewModel(
    private val repository: ParentRepository,
    private val eleveId: Int
) : ViewModel() {

    var uiState by mutableStateOf(AbsencesUiState())
        private set

    init {
        loadAbsences()
    }

    fun loadAbsences() {
        uiState = uiState.copy(isLoading = true, errorMessage = null)
        viewModelScope.launch {
            when (val result = repository.getAbsences(eleveId)) {
                is ApiResult.Success -> {
                    uiState = uiState.copy(isLoading = false, absences = result.data)
                }
                is ApiResult.Error -> {
                    uiState = uiState.copy(isLoading = false, errorMessage = result.message)
                }
            }
        }
    }
}
