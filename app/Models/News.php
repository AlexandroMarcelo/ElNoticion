<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    // protected $table = 'news'; /* reference explicit the table to be working on */
    use HasFactory;
    protected $fillable = [
        "title",
        "url",
        "category",
        "image",
        "description",
        "source",
        "published_at",
        "author",
        "language",
        "country"
    ];
}
