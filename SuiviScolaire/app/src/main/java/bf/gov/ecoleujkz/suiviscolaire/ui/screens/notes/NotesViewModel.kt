package bf.gov.ecoleujkz.suiviscolaire.ui.screens.notes

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import bf.gov.ecoleujkz.suiviscolaire.data.model.NoteMatiereDto
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ApiResult
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository
import kotlinx.coroutines.launch

data class NotesUiState(
    val isLoading: Boolean = true,
    val matieres: List<NoteMatiereDto> = emptyList(),
    val errorMessage: String? = null
)

class NotesViewModel(
    private val repository: ParentRepository,
    private val eleveId: Int
) : ViewModel() {

    var uiState by mutableStateOf(NotesUiState())
        private set

    init {
        loadNotes()
    }

    fun loadNotes() {
        uiState = uiState.copy(isLoading = true, errorMessage = null)
        viewModelScope.launch {
            when (val result = repository.getNotes(eleveId)) {
                is ApiResult.Success -> {
                    uiState = uiState.copy(isLoading = false, matieres = result.data)
                }
                is ApiResult.Error -> {
                    uiState = uiState.copy(isLoading = false, errorMessage = result.message)
                }
            }
        }
    }
}
