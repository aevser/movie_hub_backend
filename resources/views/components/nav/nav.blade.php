<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            <div class="d-flex align-items-center">
                <i class="bx bx-calendar me-2 text-primary" style="font-size: 1.25rem;"></i>
                <span class="text-muted">
                    {{ now()->format('d.m.Y') }}
                </span>
                <span class="mx-3 text-muted">|</span>
                <i class="bx bx-user-pin me-2 text-primary" style="font-size: 1.25rem;"></i>
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li>
                <form action="" method="POST">
                    @csrf
                    <button class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Выйти</span>
                    </button>
                </form>
            </li>
        </ul>

    </div>

    <style>
        .time-update {
            transition: opacity 0.2s;
        }
        .time-update.updating {
            opacity: 0.5;
        }

        .navbar-nav-right {
            flex: 1;
        }

        .align-items-center {
            white-space: nowrap;
        }
    </style>
</nav>
