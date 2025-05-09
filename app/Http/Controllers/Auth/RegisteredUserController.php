<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:admin,supplier,ukm,pengguna'], // validasi role
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Trigger event Registered
        event(new Registered($user));

        // Login user yang baru terdaftar
        Auth::login($user);

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'ukm':
                return redirect()->route('ukm.dashboard'); // Redirect ke dashboard UKM
            case 'supplier':
                return redirect()->route('supplier.dashboard'); // Redirect ke dashboard Supplier
            case 'pengguna':
                return redirect()->route('pengguna.dashboard'); // Redirect ke dashboard Pengguna
            case 'admin':
                return redirect()->route('filament.pages.dashboard'); // Redirect ke dashboard Admin (Filament)
            default:
                return redirect('/dashboard'); // Default jika role tidak sesuai
        }
    }
}