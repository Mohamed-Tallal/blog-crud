<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostShowResource extends JsonResource
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
            'user'      => UserResource::make($this->user),
            'comments'  => CommentResource::collection($this->comments),
        ];
    }
}
