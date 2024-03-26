<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $auth_user = Cache::get('authUser');

        return [
            'id'                => $this->id,
            'description'       => $this->description,
            'user'              => UserResource::make($this->user),
            'created_at'        => $this->created_at->diffForHumans(),
            'my_comment'        => $auth_user->id == $this->user_id ?? false,
            'post_id'           => $this->post_id

        ];
    }
}
