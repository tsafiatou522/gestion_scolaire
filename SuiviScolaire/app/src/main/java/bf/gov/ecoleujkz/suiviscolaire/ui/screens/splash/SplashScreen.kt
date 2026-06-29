package bf.gov.ecoleujkz.suiviscolaire.ui.screens.splash

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.padding
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import bf.gov.ecoleujkz.suiviscolaire.ui.components.AppLogo
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.GoldAccent
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.NavyPrimary

@Composable
fun SplashScreen() {
    Column(
        modifier = Modifier
            .fillMaxSize()
            .background(NavyPrimary),
        verticalArrangement = Arrangement.Center,
        horizontalAlignment = Alignment.CenterHorizontally
    ) {
        AppLogo(size = 96)
        CircularProgressIndicator(
            color = GoldAccent,
            modifier = Modifier.padding(top = 32.dp)
        )
    }
}
