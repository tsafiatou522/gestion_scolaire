package bf.gov.ecoleujkz.suiviscolaire.ui.screens.absences

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
import androidx.compose.material.icons.filled.DateRange
import androidx.compose.material3.Card
import androidx.compose.material3.CardDefaults
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.Icon
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import bf.gov.ecoleujkz.suiviscolaire.data.model.AbsenceDto
import bf.gov.ecoleujkz.suiviscolaire.ui.components.EmptyState
import bf.gov.ecoleujkz.suiviscolaire.ui.components.ScreenHeader
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.ErrorRed
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.GoldAccentLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.NavyPrimary
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SuccessGreen
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceWhite

@Composable
fun AbsencesScreen(viewModel: AbsencesViewModel) {
    val uiState = viewModel.uiState

    Column(modifier = Modifier.fillMaxSize().background(SurfaceLight)) {
        ScreenHeader(title = "Absences")

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

                uiState.absences.isEmpty() -> {
                    EmptyState(
                        icon = Icons.Filled.DateRange,
                        message = "Aucune absence enregistree."
                    )
                }

                else -> {
                    LazyColumn(modifier = Modifier.fillMaxSize().padding(16.dp)) {
                        items(uiState.absences) { absence ->
                            AbsenceCard(absence)
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun AbsenceCard(absence: AbsenceDto) {
    Card(
        modifier = Modifier.fillMaxWidth().padding(bottom = 8.dp),
        colors = CardDefaults.cardColors(containerColor = SurfaceWhite),
        shape = RoundedCornerShape(12.dp)
    ) {
        Row(modifier = Modifier.padding(16.dp), verticalAlignment = Alignment.CenterVertically) {
            Box(
                modifier = Modifier
                    .size(40.dp)
                    .background(GoldAccentLight, CircleShape),
                contentAlignment = Alignment.Center
            ) {
                Icon(
                    imageVector = Icons.Filled.DateRange,
                    contentDescription = null,
                    tint = NavyPrimary,
                    modifier = Modifier.size(20.dp)
                )
            }

            Column(modifier = Modifier.padding(start = 12.dp).fillMaxWidth()) {
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.SpaceBetween
                ) {
                    Text(
                        text = absence.date ?: "Date inconnue",
                        style = MaterialTheme.typography.bodyMedium,
                        color = NavyPrimary
                    )
                    Text(
                        text = if (absence.justifiee) "Justifiee" else "Non justifiee",
                        style = MaterialTheme.typography.bodySmall,
                        color = if (absence.justifiee) SuccessGreen else ErrorRed
                    )
                }
                if (!absence.motif.isNullOrBlank()) {
                    Text(text = absence.motif, style = MaterialTheme.typography.bodySmall)
                }
            }
        }
    }
}
