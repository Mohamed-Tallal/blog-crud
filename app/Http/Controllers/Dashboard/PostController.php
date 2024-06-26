<?php

namespace App\Http\Controllers\Dashboard;

use App\Trait\UploadFile;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostShowResource;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    
    use ApiResponse ,UploadFile;  
    public $auth_user = null;
    public function __construct(readonly PostRepositoryInterface $postRepository)
    {
        $this->auth_user = Cache::get('authUser');
    }
 
    public function index(Request $request)
    {
        $wheresIn =  $with = $wheres = $withCount = $orWheres =  [];
        $is_paginate = $request->is_paginate ?? 1;
       $wheres = ['user_id' =>  $this->auth_user->id];
        if($request->search){
            $wheres[] = ['title_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['title_ar', 'like', '%' . $request->search . '%'];
        }
        
        $result = $this->postRepository->getAll($is_paginate , $wheres, $wheresIn, $with, $withCount , $orWheres);
        return self::makeSuccess(Response::HTTP_OK , '', PostResource::collection($result), !$is_paginate );
    }
 
    public function show($id)
    {
       $result = $this->postRepository->show($id);
       return self::makeSuccess(Response::HTTP_OK,  __('messages.success'), PostShowResource::make($result));
    }

    public function store(PostRequest $request)
    {
        $data = [
            'title_en' => $request->title_en,
            'body_en' => $request->body_en,
            'title_ar' => $request->title_ar,
            'body_ar' => $request->body_ar,
            'user_id'   => $this->auth_user->id,
        ];
        if(isset($request->image)){
            $data['image'] = $this->SaveImage('uploads/posts' ,$request->file('image') );
        }
        $result = $this->postRepository->store($data);
        return self::makeSuccess(Response::HTTP_OK,  __('messages.success'), PostResource::make($result));
    }

    public function update(PostRequest $request, $id)
    {
         $data = [
            'title_en'  => $request->title_en,
            'body_en'   => $request->body_en,
            'title_ar'  => $request->title_ar,
            'body_ar'   => $request->body_ar,
         ];
         
        if(isset($request->image)){
            $post = $this->postRepository->show($id);
            $post->image == null ?? Storage::disk('public_image')->delete('/product/'.$post->img);
            $data['image'] = $this->SaveImage('uploads/posts' ,$request->file('image') );
        }
        $result = $this->postRepository->update($id , $data);
        return self::makeSuccess(Response::HTTP_OK,  __('messages.updated_successfully'));
    }


    public function destroy($id)
    {
        $post = $this->postRepository->show($id);
        $post->image == null ?? Storage::disk('public_image')->delete('/product/'.$post->img);
       $result = $this->postRepository->softDelete($id);
       return self::makeSuccess(Response::HTTP_OK,  __('messages.delete_successfully'));
    }

}
