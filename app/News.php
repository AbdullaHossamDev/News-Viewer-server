<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'userId',
        'source',
        'author',
        'type',
        'title',
        'description',
        'url',
        'urlToImage',
        'publishedAt'
    ];
}
