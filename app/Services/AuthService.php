<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected AuthRepository $authRepository
    ) {}

    public function register(array $data)
    {
        // rule: selain superadmin wajib punya region
        if (
            ($data['role'] ?? 'admin') !== 'superadmin'
            && empty($data['region_id'])
        ) {
            throw ValidationException::withMessages([
                'region_id' => 'Region wajib diisi untuk role ini'
            ]);
        }

        return $this->authRepository->createUser($data);
    }

    public function login(array $credentials): void
    {
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah'
            ]);
        }

        request()->session()->regenerate();
    }

    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
