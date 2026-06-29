package bf.gov.ecoleujkz.suiviscolaire.ui.screens.notes

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.MenuBook
import androidx.compose.material3.Card
import androidx.compose.material3.CardDefaults
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.HorizontalDivider
import androidx.compose.material3.Icon
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import bf.gov.ecoleujkz.suiviscolaire.data.model.NoteMatiereDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.TrimestreDto
import bf.gov.ecoleujkz.suiviscolaire.ui.components.EmptyState
import bf.gov.ecoleujkz.suiviscolaire.ui.components.ScreenHeader
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.GoldAccentLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.NavyPrimary
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceWhite

@Composable
fun NotesScreen(viewModel: NotesViewModel) {
    val uiState = viewModel.uiState

    Column(modifier = Modifier.fillMaxSize().background(SurfaceLight)) {
        ScreenHeader(title = "Notes")

        Box(modifier = Modifier.fillMaxSize()) {
            when {
                uiState.isLoading -> {
                    CircularProgressIndicator(modifier = Modifier.align(Alignment.Center))
                }

                uiState.errorMessage != null -> {
                    Text(
                        text = uiState.errorMessage,
                        color = MaterialTheme.colorScheme.error,
                        modifier = Modifier.align(Alignment.Center).padding(24.dp)
                    )
                }

                uiState.matieres.isEmpty() -> {
                    EmptyState(
                        icon = Icons.AutoMirrored.Filled.MenuBook,
                        message = "Aucune note enregistree pour le moment."
                    )
                }

                else -> {
                    LazyColumn(modifier = Modifier.fillMaxSize().padding(16.dp)) {
                        items(uiState.matieres) { matiere ->
                            MatiereCard(matiere)
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun MatiereCard(matiere: NoteMatiereDto) {
    Card(
        modifier = Modifier.fillMaxWidth().padding(bottom = 12.dp),
        colors = CardDefaults.cardColors(containerColor = SurfaceWhite),
        shape = RoundedCornerShape(12.dp)
    ) {
        Column(modifier = Modifier.padding(16.dp)) {
            Row(verticalAlignment = Alignment.CenterVertically) {
                Box(
                    modifier = Modifier
                        .size(32.dp)
                        .background(GoldAccentLight, CircleShape),
                    contentAlignment = Alignment.Center
                ) {
                    Icon(
                        imageVector = Icons.AutoMirrored.Filled.MenuBook,
                        contentDescription = null,
                        tint = NavyPrimary,
                        modifier = Modifier.size(16.dp)
                    )
                }
                Text(
                    text = matiere.matiere,
                    style = MaterialTheme.typography.titleMedium,
                    color = NavyPrimary,
                    modifier = Modifier.padding(start = 10.dp)
                )
            }
            HorizontalDivider(modifier = Modifier.padding(vertical = 8.dp))

            matiere.trimestres.forEach { (trimestre, data) ->
                TrimestreSection(trimestre, data)
            }
        }
    }
}

@Composable
fun TrimestreSection(trimestre: String, data: TrimestreDto) {
    Column(modifier = Modifier.padding(bottom = 8.dp)) {
        Row(
            modifier = Modifier.fillMaxWidth(),
            horizontalArrangement = Arrangement.SpaceBetween
        ) {
            Text(text = trimestre, style = MaterialTheme.typography.bodyMedium)
            Text(
                text = data.moyenne?.let { "Moy: %.2f".format(it) } ?: "Moy: N/A",
                style = MaterialTheme.typography.bodyMedium,
                color = NavyPrimary
            )
        }
        data.notes.forEach { note ->
            Text(
                text = "  ${note.note} / ${note.note_max}",
                style = MaterialTheme.typography.bodySmall
            )
        }
    }
}
