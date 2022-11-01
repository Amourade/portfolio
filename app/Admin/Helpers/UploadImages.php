<?php

namespace App\Admin\Helpers;

use App\Models\Image;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use ImageHelper;

class UploadImages{

    public function storeAndSync($images){
        //Stores images and return sync object

        $sync = collect([]);
        foreach($images as $key => $image){
            if(!$image['isDeleted']){
                if($image['isNew']){

                    $img = $image['image'];
                    $imgName = time().'.'.$img->extension();
                    $filePath = 'app/public/thumbnails/'.$imgName;
                    $resized = ImageHelper::make($img->path())->resize(300, 300, function($const){
                        $const->aspectRatio();
                    })->save(storage_path($filePath), 70);

                    $img = $image['image'];
                    $imgName = time().'.'.$img->extension();
                    $filePath = 'app/public/mediums/'.$imgName;
                    $resized = ImageHelper::make($img->path())->resize(800, 800, function($const){
                        $const->aspectRatio();
                    })->save(storage_path($filePath), 70);

                    $image['image']->storeAs('images', $imgName);

                    $image['image'] = Image::create([
                        'url'=> '/storage/images/'.$imgName,
                        'medium' => '/storage/mediums/'.$imgName,
                        'thumb'=> '/storage/thumbnails/'.$imgName,
                    ]);

                    $id = $image['image']->id;
                }else{
                    $id = Image::get()->where('url', $image['image'])->first()->id;
                }
                $sync->put($id, ['order' => $image['order']]);
            }
        }

        return $sync;
    }

    public function getImageValidator(){

        $validator = Validator::make(Request::all(), [
            'images.*' => ['array'],
            'images.*.order' => ['integer'],
            'images.*.isNew' => ['boolean'],
            'images.*.isDeleted' => ['boolean'],
            'images.*.originalImage' => [Rule::exists('images', 'url')],
        ], [
            'images.*.image.image' => 'Image must be an image.',
            'images.*.image.exists' => 'Image does not exist.'
        ]);

        $validator->sometimes('images.*.image', 'image', function($input, $item){
            return $item->isNew;
        });

        $validator->sometimes('images.*.image', [Rule::exists('images', 'url')], function($input, $item){
            return !$item->isNew && !$item->isDeleted;
        });

        return $validator;
    }

}