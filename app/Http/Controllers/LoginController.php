<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            // Sesuaikan aturan validasi sesuai kebutuhan Anda
            'nip' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            // Pesan error kustom
            'nip.required' => 'NIP wajib diisi.',
            'nip.string' => 'Format NIP tidak valid.',
            'nip.min' => 'NIP minimal 8 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $credentials = [
            'nip' => $request->input('nip'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect' => '/dashboard-pkl'
            ], 200);
        }

        throw ValidationException::withMessages([
            'nip' => ['NIP atau Password salah.']
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidasi session saat ini
        $request->session()->invalidate();

        // Regenerasi token CSRF
        $request->session()->regenerateToken();

        // Mengarahkan ke halaman utama/login
        return redirect('/');
    }
}
