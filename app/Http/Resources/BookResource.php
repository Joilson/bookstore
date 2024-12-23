<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->load('authors', 'subjects');

        // remove pivot from serialization data
        $this->authors->makeHidden('pivot');
        $this->subjects->makeHidden('pivot');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'publisher' => $this->publisher,
            'edition' => $this->edition,
            'publicationYear' => $this->publication_year,
            'price' => $this->price,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'authors' => AuthorResource::collection($this->whenLoaded('authors')),
            'subjects' => AuthorResource::collection($this->whenLoaded('subjects')),
        ];
    }
}
