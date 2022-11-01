<?php

namespace App\Http\Controllers;

use App\Admin\Helpers\UploadImages;
use App\Models\Digital;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdminDigitalController extends Controller
{
    protected $imagesUploader;

    public function __construct(UploadImages $imagesUploader){
        $this->imagesUploader = $imagesUploader;
    }

    public function index(){
        $digitals = Digital::orderBy('creation_date', 'desc')->get()->map(function($digital){
            $digital = [
                'id' => $digital->id,
                'title' => $digital->title,
                'slug' => $digital->slug,
                'image' => $digital->images[0]->url
            ];

            return $digital;
        });

        return Inertia::render('Admin/Digitals/Index', [
            'digitals'=> $digitals
        ]);
    }
    
    public function create(){
        return Inertia::render('Admin/Digitals/Create');
    }
    
    public function store(){
        $attributes = $this->validateDigital();
        Digital::create($attributes["digital"])
            ->images()
            ->sync($this->imagesUploader->storeAndSync($attributes['images']));

        return redirect('/admin/digitals')->with('success', 'Digital Ajouté!');
    }

    public function edit(Digital $digital){
        return Inertia::render('Admin/Digitals/Edit', [
            'digital' => $digital
        ]);
    }

    public function update(Digital $digital){
        $attributes = $this->validateDigital($digital);

        $digital->images()->sync($this->imagesUploader->storeAndSync($attributes['images']));
        $digital->update($attributes['digital']);

        return redirect('/admin/digitals')->with('success', 'Digital Mis à Jour!');
    }

    public function destroy(Digital $digital){
        $digital->delete();

        return back()->with('success', 'Digital Deleted!');
    }

    protected function validateDigital(?Digital $digital = null){
        $digital ??= new Digital();

        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'slug' => ['required', Rule::unique('digitals', 'slug')->ignore($digital->id)],
            'video' => 'nullable',
            'creation_date' => 'required|date'
        ]);

        return [
            'digital' => $validator->validate(),
            'images' => $this->imagesUploader->getImageValidator()->validate()['images']
        ];
    }
}
