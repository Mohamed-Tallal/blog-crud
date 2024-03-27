<?php

namespace App\Http\Controllers\Dashboard;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\CommentResource;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentController extends Controller
{
    use ApiResponse;  
    public $auth_user = null;

    public function __construct(readonly CommentRepositoryInterface $commentRepository)
    {        
        $this->auth_user = Cache::get('authUser') ?? null;
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

    public function show($id)
    {
       $result = $this->commentRepository->show($id);
       return self::makeSuccess(Response::HTTP_OK,  __('messages.success'), CommentResource::make($result));
    }

    public function store(CommentRequest $request)
    {
        $data = [
            'description'   => $request->description,
            'user_id'       => $this->auth_user->id,
            'post_id'       => $request->post_id
        ];
        $result = $this->commentRepository->store($data);
        return self::makeSuccess(Response::HTTP_OK,  __('messages.success'), CommentResource::make($result));
    }

    public function update(CommentRequest $request, $id)
    {
         $data = [
            'description' => $request->description,
         ];
         
        $result = $this->commentRepository->update($id , $data);
        return self::makeSuccess(Response::HTTP_OK,  __('messages.updated_successfully'));
    }


    public function destroy($id)
    {
       $result = $this->commentRepository->softDelete($id);
       return self::makeSuccess(Response::HTTP_OK,  __('messages.delete_successfully'));
    }

    public function bulkDelete(Request $request){
        $result = $this->commentRepository->softBulkDelete($request->ids);
        return self::makeSuccess(Response::HTTP_OK,  __('messages.delete_successfully'));
    }

}
