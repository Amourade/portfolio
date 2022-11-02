<?php

namespace App\Http\Controllers;

use App\Admin\Helpers\UploadImages;
use App\Models\Image;
use App\Models\Painting;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AdminPaintingController extends Controller
{
    protected $imagesUploader;

    public function __construct(UploadImages $imagesUploader){
        $this->imagesUploader = $imagesUploader;
    }

    public function index(){
        return Inertia::render('Admin/Paintings/Index', [
            'paintings'=> Painting::orderBy('creation_date', 'desc')->get()->map(function($painting){
                $painting = [
                    'id' => $painting->id,
                    'title' => $painting->title,
                    'slug' => $painting->slug,
                    'image' => $painting->images[0]->thumb
                ];
    
                return $painting;
            })
        ]);
    }

    public function create(){
        return Inertia::render('Admin/Paintings/Create');
    }

    public function store(){
        
        $attributes = $this->validatePainting();
        Painting::create($attributes['painting'])
            ->images()
            ->sync($this->imagesUploader->storeAndSync($attributes['images']));
    
        return redirect('/admin/paintings')->with('success', 'Peintures Ajoutée!');
    }

    public function edit(Painting $painting){
        return Inertia::render('Admin/Paintings/Edit', [
            'painting' => $painting
        ]);
    }

    public function update(Painting $painting){


        $attributes = $this->validatePainting($painting);
        $painting->images()->sync($this->imagesUploader->storeAndSync($attributes['images']));
        $painting->update($attributes['painting']);

        return redirect('/admin/paintings')->with('success', 'Peinture Mise à Jour!');
    }

    public function destroy(Painting $painting){
        $painting->delete();

        return back()->with('success', 'Painting Deleted!');
    }

    protected function validatePainting(?Painting $painting = null){

        $painting ??= new Painting();

        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'slug' => ['required', Rule::unique('paintings', 'slug')->ignore($painting->id)],
            'description' => 'required',
            'video' => 'nullable',
            'creation_date' => 'required|date',
            'height' => 'required|Numeric',
            'width' => 'required|Numeric',
            'depth' => 'required|Numeric',
        ]);

        $imagesValidator = $this->imagesUploader->getImageValidator();

        if($validator->fails() || $imagesValidator->fails()){
            $errors = $validator->errors()->merge($imagesValidator->errors());
            throw ValidationException::withMessages($errors->getMessages());
        }else{
            return [
                'painting' => $validator->validate(),
                'images' =>  $imagesValidator->validate()['images']
            ];
        }
    }
}
