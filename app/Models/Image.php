<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public function drawings()
    {
        return $this->belongsToMany(Drawing::class, 'drawing_images', 'image_id', 'drawing_id')->withPivot('order');
    }

    public function paintings()
    {
        return $this->belongsToMany(Painting::class, 'painting_images', 'painting_id', 'drawing_id')->withPivot('order');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_images', 'project_id', 'drawing_id')->withPivot('order');
    }

    public function digitals()
    {
        return $this->belongsToMany(Digital::class, 'digital_images', 'digital_id', 'drawing_id')->withPivot('order');
    }
}
