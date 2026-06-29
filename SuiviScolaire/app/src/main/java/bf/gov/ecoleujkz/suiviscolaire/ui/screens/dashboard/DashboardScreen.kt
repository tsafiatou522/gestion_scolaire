package bf.gov.ecoleujkz.suiviscolaire.ui.screens.dashboard

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material3.Card
import androidx.compose.material3.CardDefaults
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.HorizontalDivider
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import bf.gov.ecoleujkz.suiviscolaire.data.model.DerniereNoteDto
import bf.gov.ecoleujkz.suiviscolaire.ui.components.ScreenHeader
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.GoldAccent
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.NavyPrimary
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceWhite

@Composable
fun DashboardScreen(viewModel: DashboardViewModel) {
    val uiState = viewModel.uiState

    Column(modifier = Modifier.fillMaxSize().background(SurfaceLight)) {
        if (uiState.dashboard != null) {
            val dashboard = uiState.dashboard
            ScreenHeader(
                title = "${dashboard.prenom} ${dashboard.nom}",
                subtitle = dashboard.classe ?: "Classe non assignee"
            )
        } else {
            ScreenHeader(title = "Tableau de bord")
        }

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

                uiState.dashboard != null -> {
                    val dashboard = uiState.dashboard
                    Column(modifier = Modifier.fillMaxSize().padding(16.dp)) {
                        Row(modifier = Modifier.fillMaxWidth()) {
                            InfoCard(
                                label = "Moyenne generale",
                                value = dashboard.moyenne_generale?.let { "%.2f".format(it) } ?: "N/A",
                                modifier = Modifier.fillMaxWidth(0.5f).padding(end = 6.dp)
                            )
                            InfoCard(
                                label = "Rang",
                                value = dashboard.rang?.let { "$it" } ?: "N/A",
                                modifier = Modifier.fillMaxWidth().padding(start = 6.dp)
                            )
                        }

                        Text(
                            text = "Dernieres notes",
                            style = MaterialTheme.typography.titleMedium,
                            color = NavyPrimary,
                            modifier = Modifier.padding(top = 24.dp, bottom = 8.dp)
                        )

                        if (dashboard.dernieres_notes.isEmpty()) {
                            Text(text = "Aucune note enregistree pour le moment.")
                        } else {
                            Card(
                                colors = CardDefaults.cardColors(containerColor = SurfaceWhite),
                                shape = RoundedCornerShape(12.dp)
                            ) {
                                LazyColumn(modifier = Modifier.padding(horizontal = 16.dp)) {
                                    items(dashboard.dernieres_notes) { note ->
                                        DerniereNoteRow(note)
                                        HorizontalDivider()
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun InfoCard(label: String, value: String, modifier: Modifier = Modifier) {
    Card(
        modifier = modifier,
        colors = CardDefaults.cardColors(containerColor = SurfaceWhite),
        shape = RoundedCornerShape(12.dp)
    ) {
        Column(modifier = Modifier.fillMaxWidth()) {
            Box(modifier = Modifier.fillMaxWidth().height(3.dp).background(GoldAccent))
            Column(
                modifier = Modifier.padding(16.dp),
                horizontalAlignment = Alignment.CenterHorizontally
            ) {
                Text(text = value, style = MaterialTheme.typography.headlineSmall, color = NavyPrimary)
                Text(text = label, style = MaterialTheme.typography.bodySmall)
            }
        }
    }
}

@Composable
fun DerniereNoteRow(note: DerniereNoteDto) {
    Row(
        modifier = Modifier
            .fillMaxWidth()
            .padding(vertical = 12.dp),
        horizontalArrangement = Arrangement.SpaceBetween
    ) {
        Column {
            Text(text = note.matiere ?: "Matiere inconnue", style = MaterialTheme.typography.bodyLarge)
            Text(
                text = note.trimestre ?: "",
                style = MaterialTheme.typography.bodySmall
            )
        }
        Text(
            text = "${note.note} / ${note.note_max}",
            style = MaterialTheme.typography.bodyLarge,
            color = NavyPrimary
        )
    }
}
