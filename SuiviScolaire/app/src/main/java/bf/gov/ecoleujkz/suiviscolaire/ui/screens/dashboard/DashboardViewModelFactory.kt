package bf.gov.ecoleujkz.suiviscolaire.ui.screens.dashboard

import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository

class DashboardViewModelFactory(
    private val repository: ParentRepository,
    private val eleveId: Int
) : ViewModelProvider.Factory {

    @Suppress("UNCHECKED_CAST")
    override fun <T : ViewModel> create(modelClass: Class<T>): T {
        if (modelClass.isAssignableFrom(DashboardViewModel::class.java)) {
            return DashboardViewModel(repository, eleveId) as T
        }
        throw IllegalArgumentException("ViewModel inconnu: ${modelClass.name}")
    }
}
