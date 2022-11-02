<?php

namespace App\Http\Controllers;

use App\Admin\Helpers\UploadImages;
use App\Models\Image;
use App\Models\Project;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdminProjectController extends Controller
{
    protected $imagesUploader;

    public function __construct(UploadImages $imagesUploader){
        $this->imagesUploader = $imagesUploader;
    }

    public function index(){
        $projects = Project::orderBy('creation_date', 'desc')->get()->map(function($project){
            $project = [
                'id' => $project->id,
                'title' => $project->title,
                'slug' => $project->slug,
                'image' => $project->images[0]->thumb
            ];

            return $project;
        });

        return Inertia::render('Admin/Projects/Index', [
            'projects'=> $projects
        ]);
    }
    
    public function create(){
        return Inertia::render('Admin/Projects/Create');
    }
    
    public function store(){
        $attributes = $this->validateProject();
        Project::create($attributes["project"])
            ->images()
            ->sync($this->imagesUploader->storeAndSync($attributes['images']));

        return redirect('/admin/projects')->with('success', 'Projet Ajouté!');
    }

    public function edit(Project $project){
        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project
        ]);
    }

    public function update(Project $project){
        $attributes = $this->validateProject($project);
        $project->images()->sync($this->imagesUploader->storeAndSync($attributes['images']));
        $project->update($attributes['project']);

        return redirect('/admin/projects')->with('success', 'Projet Mis à Jour!');
    }

    public function destroy(Project $project){
        $project->delete();

        return back()->with('success', 'Projet Supprimé!');
    }

    protected function validateProject(?Project $project = null){

        $project ??= new Project();

        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'slug' => ['required', Rule::unique('projects', 'slug')->ignore($project->id)],
            'description' => 'required',
            'creation_date' => 'required|date',
            'url' => 'required',
        ]);

        return [
            'project' => $validator->validate(),
            'images' => $this->imagesUploader->getImageValidator()->validate()['images']
        ];
    }
}
