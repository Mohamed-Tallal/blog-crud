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
            'title'     => $this->title,
            'body'      => $this->body,
            'title_en'  => $this->title_en,
            'body_en'   => $this->body_en,
            'title_ar'  => $this->title_ar,
            'body_ar'   => $this->body_ar,
            'user'      => UserResource::make($this->user),
            'comments'  => CommentResource::collection($this->comments),
            'created_at'=> $this->created_at->diffForHumans(),
        ];
    }
}
