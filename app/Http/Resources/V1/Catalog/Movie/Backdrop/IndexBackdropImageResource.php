<?php

namespace App\Http\Resources\V1\Catalog\Movie\Backdrop;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexBackdropImageResource extends JsonResource
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
            'image_width' => $this->image_wigth,
            'image_height' => $this->image_height
        ];
    }
}
