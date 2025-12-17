<?php

namespace App\Http\Resources\V1\Catalog\Movie;

use App\Http\Resources\V1\Catalog\Actor\MovieActorResource;
use App\Http\Resources\V1\Catalog\Crew\MovieCrewResource;
use App\Http\Resources\V1\Catalog\Genre\MovieGenreResource;
use App\Http\Resources\V1\Catalog\Movie\Backdrop\IndexMovieBackdropImageResource;
use App\Http\Resources\V1\Catalog\Movie\Image\IndexMovieImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowMovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'poster_url' => $this->poster_url,
            'release_date' => $this->release_date,

            'actors' => MovieActorResource::class::collection
            (
                $this->whenLoaded('actors')
            ),

            'genres' => MovieGenreResource::collection
            (
                $this->whenLoaded('genres')
            ),

            'crews' => MovieCrewResource::collection
            (
                $this->whenLoaded('crews')
            ),

            'images' => IndexMovieImageResource::collection
            (
                $this->whenLoaded('images')
            ),

            'backdrops' => IndexMovieBackdropImageResource::collection
            (
                $this->whenLoaded('backdrops')
            )
        ];
    }
}
