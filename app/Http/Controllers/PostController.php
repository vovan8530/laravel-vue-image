<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Resources\Json\ResourceCollection;


class PostController extends Controller
{
    /**
     * @param  PostService  $service
     */
    public function __construct(protected PostService $service)
    {
    }

    /**
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return PostResource::collection(Post::paginate(10));
    }

    /**
     * @param  PostStoreRequest  $request
     * @return PostResource
     */
    public function store(PostStoreRequest $request): PostResource
    {
        $data = $request->validated();
        return new PostResource($this->service->store($data));
    }

    public function storeImage(ImageRequest $request)
    {
        $data = $request->validated();
        $filePath = $this->service->storeImage($data);

        return response()->json(['url' => url('/storage/'.$filePath)]);
    }

    /**
     * @param  Post  $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * @param  PostUpdateRequest  $request
     * @param  Post  $post
     * @return PostResource
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        $newPost = $this->service->update($data, $post);

        return new PostResource($newPost);
    }

//    public function destroy(Post $post)
//    {
//        $post->delete();
//
//        return response()->json();
//    }
}
