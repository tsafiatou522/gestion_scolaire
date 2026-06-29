package bf.gov.ecoleujkz.suiviscolaire.ui.theme

import androidx.compose.foundation.isSystemInDarkTheme
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.darkColorScheme
import androidx.compose.material3.lightColorScheme
import androidx.compose.runtime.Composable

private val DarkColorScheme = darkColorScheme(
    primary = NavyPrimaryLight,
    onPrimary = SurfaceWhite,
    secondary = GoldAccent,
    onSecondary = TextOnGold,
    tertiary = GoldAccentLight,
    background = NavyPrimaryDark,
    surface = NavyPrimaryDark,
    onBackground = SurfaceWhite,
    onSurface = SurfaceWhite,
    error = ErrorRed
)

private val LightColorScheme = lightColorScheme(
    primary = NavyPrimary,
    onPrimary = TextOnNavy,
    primaryContainer = NavyPrimaryLight,
    secondary = GoldAccent,
    onSecondary = TextOnGold,
    secondaryContainer = GoldAccentLight,
    tertiary = GoldAccentDark,
    background = SurfaceLight,
    surface = SurfaceWhite,
    onBackground = NavyPrimaryDark,
    onSurface = NavyPrimaryDark,
    error = ErrorRed
)

@Composable
fun SuiviScolaireTheme(
    darkTheme: Boolean = isSystemInDarkTheme(),
    content: @Composable () -> Unit
) {
    val colorScheme = if (darkTheme) DarkColorScheme else LightColorScheme

    MaterialTheme(
        colorScheme = colorScheme,
        typography = Typography,
        content = content
    )
}
