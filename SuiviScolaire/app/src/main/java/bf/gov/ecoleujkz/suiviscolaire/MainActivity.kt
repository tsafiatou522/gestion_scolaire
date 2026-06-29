package bf.gov.ecoleujkz.suiviscolaire

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.ui.platform.LocalContext
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.compose.rememberNavController
import bf.gov.ecoleujkz.suiviscolaire.data.local.TokenManager
import bf.gov.ecoleujkz.suiviscolaire.data.network.RetrofitClient
import bf.gov.ecoleujkz.suiviscolaire.data.repository.AuthRepository
import bf.gov.ecoleujkz.suiviscolaire.data.repository.ParentRepository
import bf.gov.ecoleujkz.suiviscolaire.ui.navigation.Routes
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.enfants.EnfantsScreen
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.enfants.EnfantsViewModel
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.enfants.EnfantsViewModelFactory
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.eleve.EleveDetailScreen
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.login.LoginScreen
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.login.LoginViewModel
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.login.LoginViewModelFactory
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.splash.SessionState
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.splash.SessionViewModel
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.splash.SessionViewModelFactory
import bf.gov.ecoleujkz.suiviscolaire.ui.screens.splash.SplashScreen
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.SuiviScolaireTheme
import kotlinx.coroutines.launch

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContent {
            SuiviScolaireTheme {
                AppRoot()
            }
        }
    }
}

@Composable
fun AppRoot() {
    val context = LocalContext.current
    val coroutineScope = rememberCoroutineScope()
    val tokenManager = TokenManager(context)
    val apiService = RetrofitClient.create(tokenManager)
    val authRepository = AuthRepository(apiService, tokenManager)
    val parentRepository = ParentRepository(apiService)

    val sessionViewModel: SessionViewModel = viewModel(
        factory = SessionViewModelFactory(authRepository)
    )

    when (sessionViewModel.sessionState) {
        SessionState.LOADING -> {
            SplashScreen()
        }
        SessionState.LOGGED_IN, SessionState.LOGGED_OUT -> {
            val navController: NavHostController = rememberNavController()
            val startDestination = if (sessionViewModel.sessionState == SessionState.LOGGED_IN) {
                Routes.ENFANTS
            } else {
                Routes.LOGIN
            }

            NavHost(navController = navController, startDestination = startDestination) {
                composable(Routes.LOGIN) {
                    val loginViewModel: LoginViewModel = viewModel(
                        factory = LoginViewModelFactory(authRepository)
                    )
                    LoginScreen(
                        viewModel = loginViewModel,
                        onLoginSuccess = {
                            navController.navigate(Routes.ENFANTS) {
                                popUpTo(Routes.LOGIN) { inclusive = true }
                            }
                        }
                    )
                }

                composable(Routes.ENFANTS) {
                    val enfantsViewModel: EnfantsViewModel = viewModel(
                        factory = EnfantsViewModelFactory(parentRepository)
                    )
                    EnfantsScreen(
                        viewModel = enfantsViewModel,
                        onEnfantClick = { eleveId ->
                            navController.navigate(Routes.dashboard(eleveId))
                        },
                        onLogoutClick = {
                            coroutineScope.launch {
                                authRepository.logout()
                                navController.navigate(Routes.LOGIN) {
                                    popUpTo(0) { inclusive = true }
                                }
                            }
                        }
                    )
                }

                composable(Routes.DASHBOARD) { backStackEntry ->
                    val eleveId = backStackEntry.arguments?.getString("eleveId")?.toIntOrNull() ?: 0
                    EleveDetailScreen(parentRepository = parentRepository, eleveId = eleveId)
                }
            }
        }
    }
}
