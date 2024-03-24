<?php

namespace App\Http\Controllers\Dashboard;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentController extends Controller
{
    use ApiResponse;  

    public function __construct(readonly CommentRepositoryInterface $commentRepository)
    {
    }
 
    public function index(Request $request)
    {
        $wheresIn =  $with = $wheres = $withCount = $orWheres =  [];
        $is_paginate = $request->is_paginate ?? 1;

        if($request->post_id){
            $wheres = ['post_id' => $request->post_id] ;
        }
        
        $result = $this->commentRepository->getAll($is_paginate , $wheres, $wheresIn, $with, $withCount , $orWheres);
        return self::makeSuccess(Response::HTTP_OK , '', CommentResource::collection($result), !$is_paginate );
    }

    public function bulkDelete(Request $request){
        $result = $this->commentRepository->softBulkDelete($request->ids);
        return self::makeSuccess(Response::HTTP_OK,  __('messages.delete_successfully'));
    }

}
