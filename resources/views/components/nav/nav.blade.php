<nav class="layout-navbar navbar navbar-expand-xl bg-navbar-theme" style="border-radius: 14px">
    <div class="catalog-wrapper w-100">

        <div class="d-flex align-items-center w-100">

            <div class="d-flex align-items-center">
                <i class="bx bx-calendar me-2 text-primary" style="font-size: 1.25rem;"></i>
                <span class="text-muted">{{ now()->format('d.m.Y') }}</span>
            </div>

            <div class="ms-auto d-flex align-items-center gap-2">

                @guest
                    <a href="{{ route('login.show') }}" class="btn btn-sm btn-outline-primary">
                        Вход
                    </a>
                    <a href="{{ route('registration.show') }}" class="btn btn-sm btn-primary">
                        Регистрация
                    </a>
                @endguest

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            Выход
                        </button>
                    </form>
                @endauth

            </div>

        </div>

    </div>
</nav>
