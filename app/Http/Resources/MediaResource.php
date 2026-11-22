<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'type'       => $this->type,
            'action'     => $this->action,
            'genres'     => $this->genres,
            'score'      => $this->score,
            'units'      => $this->units,
            'unit_label' => $this->unit_label,
            'creator'    => $this->creator,
            'users'      => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
