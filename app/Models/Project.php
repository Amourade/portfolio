<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $with = ['images'];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'project_images', 'project_id' ,'image_id')->withPivot('order')->orderByPivot('order');
    }
}
