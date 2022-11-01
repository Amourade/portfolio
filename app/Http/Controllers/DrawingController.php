<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDrawingRequest;
use App\Http\Requests\UpdateDrawingRequest;
use App\Models\Drawing;
use Inertia\Inertia;

class DrawingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drawings = Drawing::orderBy('creation_date', 'desc')->get()->map(function($drawing){
            $drawing = [
                'title' => $drawing->title,
                'slug' => '/dessins/'.$drawing->slug,
                'images' => $drawing->images
            ];
            return $drawing;
        });

        return Inertia::render('Drawings/Index', [
            'drawings' => $drawings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDrawingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDrawingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function show(Drawing $drawing)
    {
        $drawings = Drawing::orderBy('creation_date', 'desc')->get()->map(function($drawing){
            $drawing = [
                'title' => $drawing->title,
                'slug' => '/dessins/'.$drawing->slug,
                'images' => $drawing->images
            ];
            return $drawing;
        });

        return Inertia::render('Drawings/Show', [
            'drawings' => $drawings,
            'currentDrawing' => [
                'title' => $drawing->title,
                'slug' => '/dessins/'.$drawing->slug,
                'images' => $drawing->images,
                'width' => $drawing->width,
                'video' => $drawing->video,
                'height' => $drawing->height,
                'description' => $drawing->description,
                'date' => date('Y', strtotime($drawing->creation_date))
            ]
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function edit(Drawing $drawing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDrawingRequest  $request
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDrawingRequest $request, Drawing $drawing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drawing $drawing)
    {
        //
    }
}
