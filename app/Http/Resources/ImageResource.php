<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin \App\Models\Image */
class ImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'path' => $this->path,
            'thumb_url' => $this->thumb_url,
            'size' => Storage::disk('public')->size($this->path),
            'name' => str_replace('posts/', '', $this->path),
        ];
    }
}
