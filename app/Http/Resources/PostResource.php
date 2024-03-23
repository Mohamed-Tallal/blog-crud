<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
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
            'id'        => $this->id,
            'image'     => $this->image_path,
            'title'     => $this->title_en,
            'body'      => $this->body_en,
            'comments'  => $this->comments->count(),
            'user'      => UserResource::make($this->user),
            'created_at'=> $this->created_at->diffForHumans(),

        ];
    }
}
