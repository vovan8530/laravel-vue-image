<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class PostService
{
    /**
     * @param $data
     * @return Post
     */
    public function store($data): Post
    {

        try {
            DB::beginTransaction();
            $images = $data['images'] ?? [];
            unset($data['images']);

            $post = Post::firstOrCreate($data);
            if ($images) {
                foreach ($images as $image) {
                    $name = md5(Carbon::now().'_'.$image->getClientOriginalName()).'.'.$image->getClientOriginalExtension();
                    $thumbName = 'thumb_'.$name;

                    $thumbImage = ImageManager::imagick()->read($image->getRealPath());
                    $thumbImage->resize(300, 200)->save(storage_path('app/public/posts/'.$thumbName));

                    $filePath = Storage::disk('public')->putFileAs('posts', $image, $name);

                    Image::create([
                        'path' => $filePath,
                        'url' => url('/storage/'.$filePath),
                        'post_id' => $post->id,
                        'thumb_url' => url('/storage/posts/'.$thumbName),
                    ]);

                }
            }

            DB::commit();
            return $post;

        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, $exception->getMessage());

        }
    }

    public function update($data, $post)
    {

        try {
            DB::beginTransaction();
            $images = $data['images'] ?? [];
            $imageIdsDelete = $data['image_ids_delete'] ?? [];
            $imageUrlsDelete = $data['image_urls_delete'] ?? [];
            unset($data['images'], $data['image_ids_delete'], $data['image_urls_delete']);

            $post->update($data);

            $currentImages = $post->images;

            if ($imageIdsDelete) {
                foreach ($currentImages as $currentImage) {
                    if (in_array($currentImage->id, $imageIdsDelete)) {
                        Storage::disk('public')->delete($currentImage->path);
                        Storage::disk('public')->delete(str_replace('posts/', 'posts/thumb_', $currentImage->path));
                        $currentImage->delete();
                    }
                }
            }
            if ($imageUrlsDelete) {
                foreach ($imageUrlsDelete as $imageUrlDelete) {
                    $path = str_replace(config('app.url').'/storage/', '', $imageUrlDelete);
                    Storage::disk('public')->delete($path);
                }
            }


            if ($images) {
                foreach ($images as $image) {
                    $name = md5(Carbon::now().'_'.$image->getClientOriginalName()).'.'.$image->getClientOriginalExtension();
                    $thumbName = 'thumb_'.$name;

                    $thumbImage = ImageManager::imagick()->read($image->getRealPath());
                    $thumbImage->resize(300, 200)->save(storage_path('app/public/posts/'.$thumbName));

                    $filePath = Storage::disk('public')->putFileAs('posts', $image, $name);

                    Image::create([
                        'path' => $filePath,
                        'url' => url('/storage/'.$filePath),
                        'post_id' => $post->id,
                        'thumb_url' => url('/storage/posts/'.$thumbName),
                    ]);

                }
            }


            DB::commit();
            return $post;

        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, $exception->getMessage());

        }

    }

    /**
     * @param $data
     * @return string
     */
    public function storeImage($data): string
    {
        $image = $data['image'];
        $name = md5(Carbon::now().'_'.$image->getClientOriginalName()).'.'.$image->getClientOriginalExtension();
        return Storage::disk('public')->putFileAs('posts/images', $image, $name);
    }

}
