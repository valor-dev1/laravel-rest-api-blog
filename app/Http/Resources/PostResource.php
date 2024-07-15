<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'slug'  => $this->slug,
            'content'   => $this->content,
            'status'    => $this->status,
            'allow_comments' => $this->allow_comments,
            'creation_date' => $this->created_at,
            'modified_on'   => $this->updated_at,
            'comments'  => $this->comment,
            'author'    => UserResource::make($this->user),
        ];
    }
}
