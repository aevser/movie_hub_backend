<nav class="layout-navbar navbar navbar-expand-xl bg-navbar-theme" style="border-radius: 14px">
    <div class="catalog-wrapper w-100">

        <div class="d-flex align-items-center w-100">

            <div class="d-flex align-items-center">
                <i class="bx bx-calendar me-2 text-primary" style="font-size: 1.25rem;"></i>
                <span class="text-muted">{{ now()->format('d.m.Y') }}</span>
            </div>

            <a
                href="{{ route('genres.index') }}"
                class="nav-tab"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                    <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                </svg>
                <span>Жанры</span>
            </a>

            @auth
                <div class="mx-auto d-flex align-items-center gap-3">
                    <a
                        href="{{ route('favorites.index') }}"
                        class="nav-tab"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span>Избранное</span>
                    </a>

                    <a
                        href="{{ route('reviews.index') }}"
                        class="nav-tab"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                        </svg>
                        <span>Обзоры</span>
                    </a>
                </div>
            @endauth

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

<style>
    .nav-tab {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        color: #64748b;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tab:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .nav-tab.active {
        background: #1e293b;
        color: white;
    }

    .nav-tab svg {
        flex-shrink: 0;
    }
</style>
