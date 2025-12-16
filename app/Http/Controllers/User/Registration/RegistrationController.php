<?php

namespace App\Http\Controllers\User\Registration;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Registration\CreateUserRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function __construct(private UserRepository $userRepository){}

    public function show(): View
    {
        return view('user.registration.show');
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        $this->userRepository->create(data: $request->validated());

        return redirect()->route('genres.index');
    }
}
