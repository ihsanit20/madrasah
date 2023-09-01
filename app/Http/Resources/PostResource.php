<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => (int) ($this->id),
            'title'         => (string) ($this->title ?? ''),
            'description'   => (string) ($this->description ?? ''),
            'image'         => new ImageResource($this->whenLoaded('image')),
            'imageUrl'      => (string) ($this->image->url ?? ''),
            'body'          => (string) ($this->body ?? ''),
            'userId'        => (int) ($this->user_id ?? 0),
            'userName'      => (string) ($this->user->name ?? ''),
            'type'          => (int) ($this->type ?? 0),
            'valueOfType'   => (string) ($this->value_of_type ?? ''),
            'model'         => (string) (Post::class ?? ''),
        ];
    }
}
