@extends('layouts.app')

@section(
    'title',
    $movie->title . ' : ' . \Carbon\Carbon::parse($movie->release_date)->year
)

@section('content')
    <div class="catalog-wrapper">

        {{-- HEADER --}}
        <div class="page-header mb-4">
            <div class="movie-title-row mb-2">
                <a href="{{ route('genres.movies.index', $genre) }}" class="back-link">←</a>
                <h1 class="movie-title">{{ $movie->title }}</h1>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('genres.index') }}">Жанры</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('genres.movies.index', $genre) }}">
                            {{ $genre->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $movie->title }}
                    </li>
                </ol>
            </nav>
        </div>

        {{-- MOVIE --}}
        <div class="movie-show">

            {{-- LEFT COLUMN --}}
            <div class="movie-show-left">
                <div class="movie-show-poster">
                    <img
                        src="{{ $movie->poster_url }}"
                        alt="{{ $movie->title }}"
                    >
                </div>

                <div class="movie-director">
                    <div class="section-title">Режиссёр</div>

                    <div class="director-card director-card--row">
                        <div class="director-photo">
                            <img
                                src="{{ $director?->image_url ?? '/images/actor-placeholder.png' }}"
                                alt="{{ $director?->name ?? 'Информация отсутствует' }}"
                            >
                        </div>

                        <div class="director-name">
                            {{ $director?->name ?? 'Информация отсутствует' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="movie-show-content">

                <div class="movie-info-scroll">
                    <div class="movie-show-meta">
                        @if($movie->release_date)
                            <span>
                                Год выпуска:
                                {{ \Carbon\Carbon::parse($movie->release_date)->year }}
                            </span>
                        @endif

                        @if($movie->genres->count())
                            <span class="dot">•</span>
                            <span class="genre-label">Жанр:</span>

                            @foreach($movie->genres as $item)
                                <a
                                    href="{{ route('genres.movies.index', $item) }}"
                                    class="genre-link"
                                >
                                    {{ $item->name }}@if(!$loop->last),@endif
                                </a>
                            @endforeach
                        @endif
                    </div>

                    <p class="movie-show-description">
                        {{ $movie->description }}
                    </p>
                </div>

                @if($movie->actors->count())
                    <div class="movie-actors">
                        <div class="section-title">В ролях</div>

                        <div class="actors-scroll">
                            @foreach($movie->actors as $actor)
                                <div class="actor-card">
                                    <div class="actor-photo">
                                        <img
                                            src="{{ $actor->image_url ?? '/images/actor-placeholder.png' }}"
                                            alt="{{ $actor->name }}"
                                        >
                                    </div>

                                    <div class="actor-info">
                                        <div
                                            class="actor-name"
                                            title="{{ $actor->name }}"
                                        >
                                            {{ $actor->name }}
                                        </div>
                                        <div class="actor-role">
                                            {{ $actor->pivot->character }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- REVIEWS --}}
        <div class="reviews-section mt-5">

            <h2 class="fw-bold mb-4">Отзывы</h2>

            {{-- LIST --}}
            @if($reviews->count())
                <div class="d-flex flex-column gap-3 mb-4">
                    @foreach($reviews as $review)
                        <div class="card shadow-sm border-0">
                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between align-items-start mb-2"
                                >
                                    <div class="fw-semibold">
                                        {{ $review->user->name ?? 'Гость' }}
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        @if($review->rating)
                                            <span class="badge bg-warning text-dark">
                                                ★ {{ $review->rating }}
                                            </span>
                                        @endif

                                        @auth
                                            @if(auth()->id() === $review->user_id)
                                                <form
                                                    method="POST"
                                                    action="{{ route('reviews.destroy', [$genre, $movie, $review]) }}"
                                                    onsubmit="return confirm('Удалить отзыв?')"
                                                    class="d-inline"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Удалить отзыв"
                                                    >
                                                        ✕
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>

                                <p class="mb-0">
                                    {{ $review->review_text }}
                                </p>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-light text-center small mb-4">
                    Отзывов пока нет — будьте первым
                </div>
            @endif

            {{-- INFO / FORM --}}
            @guest
                <div class="alert alert-light text-center small mb-3">
                    Для публикации отзыва потребуется авторизация
                </div>
            @endguest

            @auth
                @if($userReviewExists)
                    <div class="alert alert-light text-center small mb-3">
                        Вы уже оставляли отзыв на этот фильм
                    </div>
                @else
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">

                            <h5 class="fw-semibold mb-3">
                                Оставить отзыв
                            </h5>

                            <form
                                method="POST"
                                action="{{ route('reviews.store', [$genre, $movie]) }}"
                            >
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Оценка
                                    </label>
                                    <select
                                        name="rating"
                                        class="form-select @error('rating') is-invalid @enderror"
                                    >
                                        <option value="">
                                            Выберите оценку
                                        </option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>

                                    @error('rating')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Отзыв
                                    </label>
                                    <textarea
                                        name="review_text"
                                        rows="4"
                                        class="form-control @error('review_text') is-invalid @enderror"
                                        placeholder="Напишите ваше мнение о фильме"
                                    >{{ old('review_text') }}</textarea>

                                    @error('review_text')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-dark"
                                >
                                    Отправить отзыв →
                                </button>

                            </form>

                        </div>
                    </div>
                @endif
            @endauth

        </div>

    </div>
@endsection
