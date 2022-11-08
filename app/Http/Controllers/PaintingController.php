<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaintingRequest;
use App\Http\Requests\UpdatePaintingRequest;
use App\Models\Painting;
use Inertia\Inertia;

class PaintingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paintings = Painting::orderBy('creation_date', 'desc')->get()->map(function($painting){
            $painting = [
                'title' => $painting->title,
                'slug' => '/peintures/'.$painting->slug,
                'image' => $painting->images[0]->thumb
            ];
            return $painting;
        });

        return Inertia::render('Paintings/Index', [
            'paintings' => $paintings
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
     * @param  \App\Http\Requests\StorePaintingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaintingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Painting  $painting
     * @return \Illuminate\Http\Response
     */
    public function show(Painting $painting)
    {
        $paintings = Painting::orderBy('creation_date', 'desc')->get()->map(function($painting){
            $painting = [
                'id' => $painting->id,
                'title' => $painting->title,
                'slug' => '/peintures/'.$painting->slug,
                'thumb' => $painting->images[0]->thumb,
                'width' => $painting->width,
                'height' => $painting->height,
                'description' => $painting->description,
                'date' => date('Y', strtotime($painting->creation_date))
            ];
            return $painting;
        });

        $orderedPaintings = collect($paintings)->groupBy('date')->sortKeysDesc()->values();

        //dd($orderedPaintings);

        return Inertia::render('Paintings/Show', [
            'painting' => [
                'id' => $painting->id,
                'title' => $painting->title,
                'slug' => '/peintures/'.$painting->slug,
                'images' => $painting->images,
                'width' => $painting->width,
                'video' => $painting->video,
                'height' => $painting->height,
                'description' => $painting->description,
                'date' => date('Y', strtotime($painting->creation_date))
            ],
            'paintings' => $orderedPaintings
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Painting  $painting
     * @return \Illuminate\Http\Response
     */
    public function edit(Painting $painting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaintingRequest  $request
     * @param  \App\Models\Painting  $painting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaintingRequest $request, Painting $painting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Painting  $painting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Painting $painting)
    {
        //
    }
}
