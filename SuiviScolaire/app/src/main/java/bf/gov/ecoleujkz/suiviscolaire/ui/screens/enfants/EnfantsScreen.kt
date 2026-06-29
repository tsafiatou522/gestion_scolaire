package bf.gov.ecoleujkz.suiviscolaire.ui.screens.enfants

import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.layout.statusBarsPadding
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.Logout
import androidx.compose.material.icons.filled.People
import androidx.compose.material3.Card
import androidx.compose.material3.CardDefaults
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import bf.gov.ecoleujkz.suiviscolaire.data.model.EleveDto
import bf.gov.ecoleujkz.suiviscolaire.ui.components.EmptyState
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.GoldAccent
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.NavyPrimary
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceLight
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SurfaceWhite
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.TextOnNavy

@Composable
fun EnfantsScreen(
    viewModel: EnfantsViewModel,
    onEnfantClick: (Int) -> Unit,
    onLogoutClick: () -> Unit
) {
    val uiState = viewModel.uiState

    Column(modifier = Modifier.fillMaxSize().background(SurfaceLight)) {
        Row(
            modifier = Modifier
                .fillMaxWidth()
                .background(NavyPrimary)
                .statusBarsPadding()
                .padding(horizontal = 20.dp, vertical = 8.dp),
            horizontalArrangement = Arrangement.SpaceBetween,
            verticalAlignment = Alignment.CenterVertically
        ) {
            Text(
                text = "Mes enfants",
                color = TextOnNavy,
                style = MaterialTheme.typography.titleLarge
            )
            IconButton(onClick = onLogoutClick) {
                Icon(
                    imageVector = Icons.AutoMirrored.Filled.Logout,
                    contentDescription = "Deconnexion",
                    tint = TextOnNavy
                )
            }
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

                uiState.enfants.isEmpty() -> {
                    EmptyState(
                        icon = Icons.Filled.People,
                        message = "Aucun enfant rattache a ce compte."
                    )
                }

                else -> {
                    LazyColumn(modifier = Modifier.fillMaxSize().padding(16.dp)) {
                        items(uiState.enfants) { enfant ->
                            EnfantCard(enfant = enfant, onClick = { onEnfantClick(enfant.id) })
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun EnfantCard(enfant: EleveDto, onClick: () -> Unit) {
    Card(
        modifier = Modifier
            .fillMaxWidth()
            .padding(vertical = 6.dp)
            .clickable { onClick() },
        colors = CardDefaults.cardColors(containerColor = SurfaceWhite),
        shape = RoundedCornerShape(12.dp)
    ) {
        Row(modifier = Modifier.fillMaxWidth()) {
            Box(
                modifier = Modifier
                    .width(4.dp)
                    .height(64.dp)
                    .background(GoldAccent)
            )
            Row(
                modifier = Modifier.padding(16.dp),
                verticalAlignment = Alignment.CenterVertically
            ) {
                Box(
                    modifier = Modifier
                        .size(44.dp)
                        .background(NavyPrimary, RoundedCornerShape(10.dp)),
                    contentAlignment = Alignment.Center
                ) {
                    Text(
                        text = initials(enfant.nom_complet),
                        color = TextOnNavy,
                        style = MaterialTheme.typography.titleMedium
                    )
                }

                Column(modifier = Modifier.padding(start = 12.dp)) {
                    Text(
                        text = enfant.nom_complet,
                        style = MaterialTheme.typography.titleMedium,
                        color = NavyPrimary
                    )
                    Text(
                        text = enfant.classe ?: "Classe non assignee",
                        style = MaterialTheme.typography.bodyMedium
                    )
                }
            }
        }
    }
}

private fun initials(nomComplet: String): String {
    val parts = nomComplet.trim().split(" ").filter { it.isNotBlank() }
    return parts.take(2).map { it.first().uppercaseChar() }.joinToString("")
}
