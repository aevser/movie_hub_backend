<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Login\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('login.show');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return back()
                ->withErrors(['email' => 'Неверная почта или пароль'])
                ->onlyInput('email');
        }

        return redirect()->route('catalog.genres.index');
    }
}
