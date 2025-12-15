<?php

namespace App\Http\Resources\V1\Catalog\Crew;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieCrewResource extends JsonResource
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
            'image_url' => $this->image_url,
            'job' => $this->pivot->job,
            'department' => $this->pivot->department
        ];
    }
}
