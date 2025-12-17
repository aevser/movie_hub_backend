<?php

namespace App\Http\Controllers\User\Registration;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Registration\CreateUserRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function __construct(private UserRepository $userRepository){}

    public function show(): View
    {
        return view('registration.show');
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        $user = $this->userRepository->create
        (
            data: $request->validated()
        );

        Auth::login(user: $user);

        return redirect()
            ->route('catalog.genres.index')
            ->with('success', 'Регистрация успешно завершена!');
    }
}
