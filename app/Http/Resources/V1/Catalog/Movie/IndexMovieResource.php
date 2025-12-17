<?php

namespace App\Http\Resources\V1\Catalog\Movie;

use App\Http\Resources\V1\Catalog\Actor\IndexMovieActorResource;
use App\Http\Resources\V1\Catalog\Crew\IndexCrewResource;
use App\Http\Resources\V1\Catalog\Genre\IndexMovieGenreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexMovieResource extends JsonResource
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

            'genres' => IndexMovieGenreResource::collection
            (
                $this->whenLoaded('genres')
            )
        ];
    }
}
