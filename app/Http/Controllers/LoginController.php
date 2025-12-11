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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
