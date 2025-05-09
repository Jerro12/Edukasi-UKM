<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            // Autentikasi user
            $request->authenticate();

            $request->session()->regenerate();

            $user = Auth::user();

            // Cek role dan arahkan ke halaman sesuai role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('filament.pages.dashboard'); // Filament admin panel
                case 'ukm':
                    return redirect()->route('ukm.dashboard');
                case 'supplier':
                    return redirect()->route('supplier.dashboard');
                case 'pengguna':
                    return redirect()->route('pengguna.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Role tidak dikenali.']);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
