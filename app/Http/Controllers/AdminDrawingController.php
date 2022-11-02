<?php

namespace App\Http\Controllers;

use App\Admin\Helpers\UploadImages;
use App\Models\Drawing;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdminDrawingController extends Controller
{
    protected $imagesUploader;

    public function __construct(UploadImages $imagesUploader){
        $this->imagesUploader = $imagesUploader;
    }

    public function index(){
        $drawings = Drawing::orderBy('creation_date', 'desc')->get()->map(function($drawing){
            $drawing = [
                'id' => $drawing->id,
                'title' => $drawing->title,
                'slug' => $drawing->slug,
                'image' => $drawing->images[0]->thumb
            ];

            return $drawing;
        });

        return Inertia::render('Admin/Drawings/Index', [
            'drawings'=> $drawings
        ]);
    }
    
    public function create(){
        return Inertia::render('Admin/Drawings/Create');
    }
    
    public function store(){
        $attributes = $this->validateDrawing();
        Drawing::create($attributes["drawing"])
            ->images()
            ->sync($this->imagesUploader->storeAndSync($attributes['images']));

        return redirect('/admin/drawings')->with('success', 'Dessin Ajouté!');
    }

    public function edit(Drawing $drawing){
        return Inertia::render('Admin/Drawings/Edit', [
            'drawing' => $drawing
        ]);
    }

    public function update(Drawing $drawing){
        $attributes = $this->validateDrawing($drawing);

        $drawing->images()->sync($this->imagesUploader->storeAndSync($attributes['images']));
        $drawing->update($attributes['drawing']);

        return redirect('/admin/drawings')->with('success', 'Dessin Mis à Jour!');
    }

    public function destroy(Drawing $drawing){
        $drawing->delete();

        return back()->with('success', 'Drawing Deleted!');
    }

    protected function validateDrawing(?Drawing $drawing = null){
        $drawing ??= new Drawing();

        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'slug' => ['required', Rule::unique('drawings', 'slug')->ignore($drawing->id)],
            'description' => 'required',
            'video' => 'nullable',
            'creation_date' => 'required|date',
            'height' => 'required|Numeric',
            'width' => 'required|Numeric',
            'depth' => 'nullable|Numeric',
        ]);

        return [
            'drawing' => $validator->validate(),
            'images' => $this->imagesUploader->getImageValidator()->validate()['images']
        ];
    }
}
