<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Activity;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();
            $user = Auth::user();

            // 👨‍🏫 Enseignant = vérification par code
            if ($user->role === 'enseignant') {

                $code = rand(100000, 999999);

                $user->update([
                    'verification' => $code
                ]);

                // Email code enseignant
                Mail::to($user->email)
                    ->send(new \App\Mail\VerificationCodeMail($code));

                // Notification directeur
               Mail::to(config('mail.from.address'))
    ->send(new \App\Mail\EnseignantConnexionMail($user));
    
                // Log activité
                Activity::create([
                    'action' => 'Connexion enseignant',
                    'details' => "Enseignant {$user->name} s'est connecté.",
                    'user_id' => $user->id,
                ]);

                return redirect()->route('verification.code');
            }

            // autres rôles
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    // ✅ AJOUT IMPORTANT
    public function showVerificationForm()
    {
        return view('auth.verification_code');
    }

    // ✅ Vérification du code
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $user = Auth::user();

        if ($user && $user->verification == $request->code) {

            $user->update([
                'verification' => null
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'code' => 'Code incorrect.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}