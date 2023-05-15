<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class test extends Model
{
    use HasFactory;

    protected $table = "test";
    protected $fillable = ["title", "author", "likes", "description", "image_url", "ingredients"];
}
