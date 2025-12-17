@extends('layouts.app')

@section('title', 'Вход')

@section('content')

    <div class="page-header mb-4 text-center">
        <h2 class="fw-bold mb-1">Вход</h2>
    </div>

    <div class="d-flex justify-content-center">
        <div class="bg-white p-4 p-md-5 shadow-sm"
             style="width: 100%; max-width: 420px; border-radius: 14px;">

            <form
                method="POST"
                action="{{ route('login') }}"
                class="d-flex flex-column gap-3"
            >
                @csrf

                <div class="form-group">
                    <label class="form-label fw-semibold">Почта</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="example@mail.com"
                    >
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label fw-semibold">Пароль</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                        placeholder="********"
                    >
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark btn-lg mt-2">
                    Войти →
                </button>

            </form>

        </div>
    </div>

@endsection
