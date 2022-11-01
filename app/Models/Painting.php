<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    use HasFactory;

    protected $with = ['images'];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'painting_images', 'painting_id' ,'image_id')->withPivot('order')->orderByPivot('order');
    }
}
