@extends('layouts.app')

@section('title', 'Жанры')

@section('content')

    <div class="page-header mb-4">
        <h2 class="fw-bold mb-1">Жанры</h2>
    </div>

    <div class="genre-list d-flex flex-column gap-3">
        @forelse ($genres as $genre)
            <a href="{{ route('catalog.genres.movies.index', $genre) }}" class="genre-row">
                <span class="genre-title">{{ $genre->name }}</span>
                <span class="genre-arrow">→</span>
            </a>
        @empty
            <div class="alert alert-secondary text-center mb-0">
                Жанры не найдены
            </div>
        @endforelse
    </div>

    @if($genres->hasPages())
        <div class="d-flex justify-content-end mt-4">
            {{ $genres->appends(request()->query())->links('components.pagination.pagination') }}
        </div>
    @endif

@endsection
