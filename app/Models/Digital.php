<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Digital extends Model
{
    use HasFactory;

    protected $with = ['images'];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'digital_images', 'digital_id' ,'image_id')->withPivot('order')->orderByPivot('order');
    }
}
