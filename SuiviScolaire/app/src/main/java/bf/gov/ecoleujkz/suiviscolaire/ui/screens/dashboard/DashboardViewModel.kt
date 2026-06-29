package bf.gov.ecoleujkz.suiviscolaire.ui.screens.dashboard

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import bf.gov.ecoleujkz.suiviscolaire.data.model.DashboardDto
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ApiResult
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository
import kotlinx.coroutines.launch

data class DashboardUiState(
    val isLoading: Boolean = true,
    val dashboard: DashboardDto? = null,
    val errorMessage: String? = null
)

class DashboardViewModel(
    private val repository: ParentRepository,
    private val eleveId: Int
) : ViewModel() {

    var uiState by mutableStateOf(DashboardUiState())
        private set

    init {
        loadDashboard()
    }

    fun loadDashboard() {
        uiState = uiState.copy(isLoading = true, errorMessage = null)
        viewModelScope.launch {
            when (val result = repository.getDashboard(eleveId)) {
                is ApiResult.Success -> {
                    uiState = uiState.copy(isLoading = false, dashboard = result.data)
                }
                is ApiResult.Error -> {
                    uiState = uiState.copy(isLoading = false, errorMessage = result.message)
                }
            }
        }
    }
}
