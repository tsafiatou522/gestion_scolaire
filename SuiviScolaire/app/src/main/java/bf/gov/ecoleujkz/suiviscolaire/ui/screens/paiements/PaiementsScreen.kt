package bf.gov.ecoleujkz.suiviscolaire.ui.screens.paiements

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
import androidx.compose.material.icons.filled.Payments
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
import bf.gov.ecoleujkz.suiviscolaire.data.model.PaiementDto
import bf.gov.ecoleujkz.suiviscolaire.data.model.PaiementsDto
import bf.gov.ecoleujkz.suiviscolaire.ui.components.EmptyState
import bf.gov.ecoleujkz.suiviscolaire.ui.components.ScreenHeader
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.GoldAccentDark
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.GoldAccentLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.NavyPrimary
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SuccessGreen
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceWhite

@Composable
fun PaiementsScreen(viewModel: PaiementsViewModel) {
    val uiState = viewModel.uiState

    Column(modifier = Modifier.fillMaxSize().background(SurfaceLight)) {
        ScreenHeader(title = "Paiements")

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

                uiState.paiements != null -> {
                    val paiements = uiState.paiements
                    Column(modifier = Modifier.fillMaxSize().padding(16.dp)) {
                        RecapPaiements(paiements)

                        Text(
                            text = "Historique",
                            style = MaterialTheme.typography.titleMedium,
                            color = NavyPrimary,
                            modifier = Modifier.padding(top = 24.dp, bottom = 8.dp)
                        )

                        if (paiements.historique.isEmpty()) {
                            EmptyState(
                                icon = Icons.Filled.Payments,
                                message = "Aucun paiement enregistre."
                            )
                        } else {
                            Card(
                                colors = CardDefaults.cardColors(containerColor = SurfaceWhite),
                                shape = RoundedCornerShape(12.dp)
                            ) {
                                LazyColumn(modifier = Modifier.padding(horizontal = 16.dp)) {
                                    items(paiements.historique) { paiement ->
                                        PaiementRow(paiement)
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
fun RecapPaiements(paiements: PaiementsDto) {
    Card(
        modifier = Modifier.fillMaxWidth(),
        colors = CardDefaults.cardColors(containerColor = SurfaceWhite),
        shape = RoundedCornerShape(12.dp)
    ) {
        Column(modifier = Modifier.padding(16.dp)) {
            LigneRecap("Montant total du", "%.0f FCFA".format(paiements.montant_total_du))
            LigneRecap("Montant verse", "%.0f FCFA".format(paiements.montant_total_verse))
            LigneRecap("Reste a payer", "%.0f FCFA".format(paiements.reste_a_payer))
            HorizontalDivider(modifier = Modifier.padding(vertical = 8.dp))
            LigneRecap("Statut", paiements.statut, highlight = true)
        }
    }
}

@Composable
fun LigneRecap(label: String, value: String, highlight: Boolean = false) {
    Row(
        modifier = Modifier.fillMaxWidth().padding(vertical = 4.dp),
        horizontalArrangement = Arrangement.SpaceBetween
    ) {
        Text(text = label, style = MaterialTheme.typography.bodyMedium)
        Text(
            text = value,
            style = MaterialTheme.typography.bodyMedium,
            color = if (highlight) SuccessGreen else NavyPrimary
        )
    }
}

@Composable
fun PaiementRow(paiement: PaiementDto) {
    Row(modifier = Modifier.fillMaxWidth().padding(vertical = 12.dp), verticalAlignment = Alignment.CenterVertically) {
        Box(
            modifier = Modifier
                .size(36.dp)
                .background(GoldAccentLight, CircleShape),
            contentAlignment = Alignment.Center
        ) {
            Icon(
                imageVector = Icons.Filled.Payments,
                contentDescription = null,
                tint = NavyPrimary,
                modifier = Modifier.size(18.dp)
            )
        }
        Column(modifier = Modifier.padding(start = 12.dp).fillMaxWidth()) {
            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween
            ) {
                Text(text = paiement.date_paiement ?: "Date inconnue", style = MaterialTheme.typography.bodyMedium)
                Text(
                    text = "%.0f FCFA".format(paiement.montant_verse),
                    style = MaterialTheme.typography.bodyMedium,
                    color = GoldAccentDark
                )
            }
            if (!paiement.observation.isNullOrBlank()) {
                Text(text = paiement.observation, style = MaterialTheme.typography.bodySmall)
            }
        }
    }
}
