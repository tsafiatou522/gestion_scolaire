package bf.gov.ecoleujkz.suiviscolaire.ui.components

import androidx.compose.foundation.Canvas
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.geometry.Offset
import androidx.compose.ui.graphics.Path
import androidx.compose.ui.unit.dp
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.GoldAccent
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.NavyPrimary
import bf.gov.ecoleujkz.suiviscolaire.ui.theme.NavyPrimaryDark

@Composable
fun AppLogo(size: Int = 72) {
    Box(
        modifier = Modifier
            .size(size.dp)
            .background(GoldAccent, RoundedCornerShape((size * 0.25).dp))
    ) {
        Canvas(modifier = Modifier.size(size.dp)) {
            val w = this.size.width
            val h = this.size.height
            val scale = w / 108f

            val leftPage = Path().apply {
                moveTo(54f * scale, 34f * scale)
                cubicTo(48f * scale, 29f * scale, 38f * scale, 26f * scale, 30f * scale, 26f * scale)
                cubicTo(28f * scale, 26f * scale, 27f * scale, 27.2f * scale, 27f * scale, 29f * scale)
                lineTo(27f * scale, 68f * scale)
                cubicTo(27f * scale, 69.8f * scale, 28f * scale, 71f * scale, 30f * scale, 71f * scale)
                cubicTo(38f * scale, 71f * scale, 48f * scale, 74f * scale, 54f * scale, 79f * scale)
                close()
            }

            val rightPage = Path().apply {
                moveTo(54f * scale, 34f * scale)
                lineTo(54f * scale, 79f * scale)
                cubicTo(60f * scale, 74f * scale, 70f * scale, 71f * scale, 78f * scale, 71f * scale)
                cubicTo(80f * scale, 71f * scale, 81f * scale, 69.8f * scale, 81f * scale, 68f * scale)
                lineTo(81f * scale, 29f * scale)
                cubicTo(81f * scale, 27.2f * scale, 80f * scale, 26f * scale, 78f * scale, 26f * scale)
                cubicTo(70f * scale, 26f * scale, 60f * scale, 29f * scale, 54f * scale, 34f * scale)
                close()
            }

            drawPath(leftPage, color = NavyPrimary)
            drawPath(rightPage, color = NavyPrimaryDark)
        }
    }
}
