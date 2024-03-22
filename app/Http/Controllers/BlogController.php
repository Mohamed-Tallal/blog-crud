<?php

namespace App\Http\Controllers;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostShowResource;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\PostRepositoryInterface;

class BlogController extends Controller
{
  
    use ApiResponse;  

    public function __construct(readonly PostRepositoryInterface $postRepository)
    {
    }
 
    public function index(Request $request)
    {
        $wheresIn =  $with = $wheres = $withCount = $orWheres =  [];
        $is_paginate = $request->is_paginate ?? 0;
 
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


}
 
