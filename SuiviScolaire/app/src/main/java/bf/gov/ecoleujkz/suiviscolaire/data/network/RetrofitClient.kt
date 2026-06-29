package bf.gov.ecoleujkz.suiviscolaire.data.network

import bf.gov.ecoleujkz.suiviscolaire.data.local.TokenManager
import kotlinx.coroutines.runBlocking
import okhttp3.Interceptor
import okhttp3.OkHttpClient
import okhttp3.Response
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object RetrofitClient {

    // 10.0.2.2 correspond a l'hote local depuis l'emulateur Android.
    // Pour un appareil physique, remplacer par l'adresse IP locale de la machine (ex: 192.168.x.x).
    private const val BASE_URL = "http://10.0.2.2:8000/api/"

    fun create(tokenManager: TokenManager): ApiService {
        val authInterceptor = Interceptor { chain ->
            val token = runBlocking { tokenManager.getTokenOnce() }
            val requestBuilder = chain.request().newBuilder()
            requestBuilder.addHeader("Accept", "application/json")
            if (!token.isNullOrEmpty()) {
                requestBuilder.addHeader("Authorization", "Bearer $token")
            }
            chain.proceed(requestBuilder.build())
        }

        val loggingInterceptor = HttpLoggingInterceptor().apply {
            level = HttpLoggingInterceptor.Level.BODY
        }

        val okHttpClient = OkHttpClient.Builder()
            .addInterceptor(authInterceptor)
            .addInterceptor(loggingInterceptor)
            .build()

        val retrofit = Retrofit.Builder()
            .baseUrl(BASE_URL)
            .client(okHttpClient)
            .addConverterFactory(GsonConverterFactory.create())
            .build()

        return retrofit.create(ApiService::class.java)
    }
}
