<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Region;


class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showLogin()
    {
        return Inertia::render('auth/login');
    }

    public function showRegister()
    {
         return Inertia::render('auth/register', [
        'regions' => Region::select('id', 'name')->get()
    ]);
    }

    public function register(Request $request)
    {
       

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:superadmin,admin,approver',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        $this->authService->register($data);
return Inertia::location(route('login'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $this->authService->login($credentials);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $this->authService->logout();

        return redirect()->route('login');
    }
}
