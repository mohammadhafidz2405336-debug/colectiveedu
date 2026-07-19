<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Boleh dihapus jika tidak dipakai di tempat lain
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    // --- 1. UNTUK SISWA ---
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Tambahkan validasi username di sini agar membaca inputan form dan memastikan tidak ada duplikat di tabel users
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'kelas' => ['required', 'string', 'max:10'], // Disesuaikan sedikit panjang max-nya untuk "Alumni"
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        // Hapus pembuatan ID otomatis di backend, langsung simpan data dari $request->username
        $user = User::create([
            'name' => $request->name, 
            'username' => $request->username, // Mengambil ID otomatis dari hasil generate di halaman Register
            'gender' => $request->gender, 
            'kelas' => $request->kelas,
            'role' => 'student', 
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect(route('dashboard', absolute: false));
    }

    // --- 2. UNTUK GURU BK ---
    public function createGuru() { return view('auth.register-guru'); }

    public function storeGuru(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:25', 'unique:'.User::class], // Validasi NIP
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name, 
            'nip' => $request->nip,
            'gender' => $request->gender, 
            'role' => 'guru_bk',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect(route('bk.dashboard', absolute: false));
    }
}