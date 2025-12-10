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
            'nip' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.string' => 'Format NIP tidak valid.',
            'nip.min' => 'NIP minimal 8 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // 2. Kredensial untuk Autentikasi
        $credentials = $request->only('nip', 'password');

        // 3. Autentikasi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika Autentikasi berhasil
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect' => '/dashboard' // Ganti dengan route dashboard Anda
            ], 200);
        }

        // 4. Autentikasi gagal
        // Kita akan melempar ValidationException agar respons error sesuai dengan format JSON
        throw ValidationException::withMessages([
            'nip' => ['NIP atau Password salah.']
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/'); // Arahkan kembali ke halaman utama atau login
    }
}
