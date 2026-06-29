package bf.gov.ecoleujkz.suiviscolaire.ui.screens.eleve

import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.statusBarsPadding
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.AccountBox
import androidx.compose.material.icons.filled.Campaign
import androidx.compose.material.icons.filled.DateRange
import androidx.compose.material.icons.filled.Home
import androidx.compose.material.icons.filled.Payments
import androidx.compose.material3.Icon
import androidx.compose.material3.NavigationBar
import androidx.compose.material3.NavigationBarItem
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.ui.Modifier
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavDestination.Companion.hierarchy
import androidx.navigation.NavGraph.Companion.findStartDestination
import androidx.navigation.NavHostController
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.compose.currentBackStackEntryAsState
import androidx.navigation.compose.rememberNavController
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.absences.AbsencesScreen
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.absences.AbsencesViewModel
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.absences.AbsencesViewModelFactory
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.annonces.AnnoncesScreen
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.annonces.AnnoncesViewModel
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.annonces.AnnoncesViewModelFactory
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.dashboard.DashboardScreen
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.dashboard.DashboardViewModel
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.dashboard.DashboardViewModelFactory
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.notes.NotesScreen
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.notes.NotesViewModel
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.notes.NotesViewModelFactory
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.paiements.PaiementsScreen
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.paiements.PaiementsViewModel
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.paiements.PaiementsViewModelFactory

private object SousRoutes {
    const val DASHBOARD = "sous_dashboard"
    const val NOTES = "sous_notes"
    const val PAIEMENTS = "sous_paiements"
    const val ABSENCES = "sous_absences"
    const val ANNONCES = "sous_annonces"
}

private data class TabItem(val route: String, val label: String, val icon: androidx.compose.ui.graphics.vector.ImageVector)

private val tabs = listOf(
    TabItem(SousRoutes.DASHBOARD, "Accueil", Icons.Filled.Home),
    TabItem(SousRoutes.NOTES, "Notes", Icons.Filled.AccountBox),
    TabItem(SousRoutes.PAIEMENTS, "Paiements", Icons.Filled.Payments),
    TabItem(SousRoutes.ABSENCES, "Absences", Icons.Filled.DateRange),
    TabItem(SousRoutes.ANNONCES, "Annonces", Icons.Filled.Campaign)
)

@Composable
fun EleveDetailScreen(parentRepository: ParentRepository, eleveId: Int) {
    val tabNavController: NavHostController = rememberNavController()

    Scaffold(
        modifier = Modifier.statusBarsPadding(),
        bottomBar = {
            NavigationBar {
                val navBackStackEntry by tabNavController.currentBackStackEntryAsState()
                val currentDestination = navBackStackEntry?.destination

                tabs.forEach { tab ->
                    val selected = currentDestination?.hierarchy?.any { it.route == tab.route } == true
                    NavigationBarItem(
                        selected = selected,
                        onClick = {
                            tabNavController.navigate(tab.route) {
                                popUpTo(tabNavController.graph.findStartDestination().id) {
                                    saveState = true
                                }
                                launchSingleTop = true
                                restoreState = true
                            }
                        },
                        icon = { Icon(tab.icon, contentDescription = tab.label) },
                        label = { Text(tab.label) }
                    )
                }
            }
        }
    ) { innerPadding ->
        NavHost(
            navController = tabNavController,
            startDestination = SousRoutes.DASHBOARD,
            modifier = Modifier
                .fillMaxSize()
                .padding(innerPadding)
        ) {
            composable(SousRoutes.DASHBOARD) {
                val vm: DashboardViewModel = viewModel(
                    factory = DashboardViewModelFactory(parentRepository, eleveId)
                )
                DashboardScreen(viewModel = vm)
            }
            composable(SousRoutes.NOTES) {
                val vm: NotesViewModel = viewModel(
                    factory = NotesViewModelFactory(parentRepository, eleveId)
                )
                NotesScreen(viewModel = vm)
            }
            composable(SousRoutes.PAIEMENTS) {
                val vm: PaiementsViewModel = viewModel(
                    factory = PaiementsViewModelFactory(parentRepository, eleveId)
                )
                PaiementsScreen(viewModel = vm)
            }
            composable(SousRoutes.ABSENCES) {
                val vm: AbsencesViewModel = viewModel(
                    factory = AbsencesViewModelFactory(parentRepository, eleveId)
                )
                AbsencesScreen(viewModel = vm)
            }
            composable(SousRoutes.ANNONCES) {
                val vm: AnnoncesViewModel = viewModel(
                    factory = AnnoncesViewModelFactory(parentRepository)
                )
                AnnoncesScreen(viewModel = vm)
            }
        }
    }
}
