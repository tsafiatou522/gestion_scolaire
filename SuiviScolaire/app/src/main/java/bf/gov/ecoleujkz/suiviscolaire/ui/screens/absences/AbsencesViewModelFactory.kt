package bf.gov.ecoleujkz.suiviscolaire.ui.screens.absences

import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository

class AbsencesViewModelFactory(
    private val repository: ParentRepository,
    private val eleveId: Int
) : ViewModelProvider.Factory {

    @Suppress("UNCHECKED_CAST")
    override fun <T : ViewModel> create(modelClass: Class<T>): T {
        if (modelClass.isAssignableFrom(AbsencesViewModel::class.java)) {
            return AbsencesViewModel(repository, eleveId) as T
        }
        throw IllegalArgumentException("ViewModel inconnu: ${modelClass.name}")
    }
}
