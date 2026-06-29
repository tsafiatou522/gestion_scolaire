package bf.gov.ecoleujkz.suiviscolaire.ui.screens.annonces

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Campaign
import androidx.compose.material3.AssistChip
import androidx.compose.material3.AssistChipDefaults
import androidx.compose.material3.Card
import androidx.compose.material3.CardDefaults
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import bf.gov.ecoleujkz.suiviscolaire.data.model.AnnonceDto
import bf.gov.ecoleujkz.suiviscolaire.ui.components.EmptyState
import bf.gov.ecoleujkz.suiviscolaire.ui.components.ScreenHeader
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.GoldAccentLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.NavyPrimary
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceWhite
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.TextOnGold

@Composable
fun AnnoncesScreen(viewModel: AnnoncesViewModel) {
    val uiState = viewModel.uiState

    Column(modifier = Modifier.fillMaxSize().background(SurfaceLight)) {
        ScreenHeader(title = "Annonces")

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

                uiState.annonces.isEmpty() -> {
                    EmptyState(
                        icon = Icons.Filled.Campaign,
                        message = "Aucune annonce pour le moment."
                    )
                }

                else -> {
                    LazyColumn(modifier = Modifier.fillMaxSize().padding(16.dp)) {
                        items(uiState.annonces) { annonce ->
                            AnnonceCard(annonce)
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun AnnonceCard(annonce: AnnonceDto) {
    Card(
        modifier = Modifier.fillMaxWidth().padding(bottom = 12.dp),
        colors = CardDefaults.cardColors(containerColor = SurfaceWhite),
        shape = RoundedCornerShape(12.dp)
    ) {
        Column(modifier = Modifier.padding(16.dp)) {
            AssistChip(
                onClick = {},
                label = { Text(annonce.type) },
                colors = AssistChipDefaults.assistChipColors(
                    containerColor = GoldAccentLight,
                    labelColor = TextOnGold
                )
            )
            Text(
                text = annonce.titre,
                style = MaterialTheme.typography.titleMedium,
                color = NavyPrimary,
                modifier = Modifier.padding(top = 8.dp)
            )
            Text(
                text = annonce.contenu,
                style = MaterialTheme.typography.bodyMedium,
                modifier = Modifier.padding(top = 4.dp)
            )
            Text(
                text = annonce.date ?: "",
                style = MaterialTheme.typography.bodySmall,
                modifier = Modifier.padding(top = 8.dp)
            )
        }
    }
}
