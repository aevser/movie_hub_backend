@extends('layouts.app')

@section('title', 'Жанры')

@section('content')
    <div class="container-xxl py-5">
        <div class="catalog-wrapper">

            <div class="page-header mb-4">
                <h2 class="fw-bold mb-1">Жанры</h2>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page" style="padding-top: 10px">
                            Жанры
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="genre-list d-flex flex-column gap-3">
                @forelse ($genres as $genre)
                    <a href="{{ route('genres.movies.index', $genre) }}"
                       class="genre-row">

                        <span class="genre-title">
                            {{ $genre->name }}
                        </span>

                        <span class="genre-arrow">
                            →
                        </span>

                    </a>
                @empty
                    <div class="alert alert-secondary text-center mb-0">
                        Жанры не найдены
                    </div>
                @endforelse
            </div>

            @if($genres->hasPages())
                <div class="card-footer bg-transparent border-0 d-flex justify-content-end">
                    {{ $genres->appends(request()->query())->links('components.pagination.pagination') }}
                </div>
            @endif

        </div>
    </div>

    <style>

        .catalog-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }

        .breadcrumb {
            font-size: .85rem;
        }

        .breadcrumb-item.active {
            color: #adb5bd;
        }

        .genre-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            text-decoration: none;
            transition: all .25s ease;
        }

        .genre-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.12);
            border-color: transparent;
        }

        .genre-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: #212529;
        }

        .genre-arrow {
            color: #adb5bd;
            font-size: 1.2rem;
            transition: transform .25s ease;
        }

        .genre-row:hover .genre-arrow {
            transform: translateX(4px);
            color: #696cff;
        }

    </style>
@endsection
