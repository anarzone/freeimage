<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    const MAIN_PATH = "media";
    const STANDARD_PATH = "standard";
    const THUMBNAIL_PATH = "thumbnails";

    protected $fillable = ['name'];
}
