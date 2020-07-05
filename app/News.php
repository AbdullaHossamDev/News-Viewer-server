<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
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
