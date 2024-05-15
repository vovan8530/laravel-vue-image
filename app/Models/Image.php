<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Image
 *
 *
 * @property int $id
 * @property string $path
 * @property string $url
 * @property int $post_id
 * @property string $thumb_url
 */
class Image extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'path',
        'url',
        'post_id',
        'thumb_url'
    ];
}
