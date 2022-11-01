<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    use HasFactory;

    protected $with = ['images'];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'drawing_images', 'drawing_id' ,'image_id')->withPivot('order')->orderByPivot('order');
    }
}
