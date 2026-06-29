package bf.gov.ecoleujkz.suiviscolaire.ui.screens.annonces

import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository

class AnnoncesViewModelFactory(private val repository: ParentRepository) : ViewModelProvider.Factory {

    @Suppress("UNCHECKED_CAST")
    override fun <T : ViewModel> create(modelClass: Class<T>): T {
        if (modelClass.isAssignableFrom(AnnoncesViewModel::class.java)) {
            return AnnoncesViewModel(repository) as T
        }
        throw IllegalArgumentException("ViewModel inconnu: ${modelClass.name}")
    }
}
