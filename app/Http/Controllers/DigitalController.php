<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDigitalRequest;
use App\Http\Requests\UpdateDigitalRequest;
use App\Models\Digital;
use Inertia\Inertia;

class DigitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $digitals = Digital::orderBy('creation_date', 'desc')->get()->map(function($drawing){
            $digital = [
                'title' => $drawing->title,
                'slug' => '/digitaux/'.$drawing->slug,
                'images' => $drawing->images
            ];
            return $digital;
        });

        return Inertia::render('Digitals/Index', [
            'digitals' => $digitals
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
     * @param  \App\Http\Requests\StoreDigitalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDigitalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Digital  $digital
     * @return \Illuminate\Http\Response
     */
    public function show(Digital $digital)
    {
        $digitals = Digital::orderBy('creation_date', 'desc')->get()->map(function($drawing){
            $digital = [
                'title' => $drawing->title,
                'slug' => '/digitaux/'.$drawing->slug,
                'images' => $drawing->images
            ];
            return $digital;
        });

        return Inertia::render('Digitals/Show', [
            'digitals' => $digitals,
            'current' => [
                'title' => $digital->title,
                'slug' => '/digitaux/'.$digital->slug,
                'images' => $digital->images,
                'date' => date('Y', strtotime($digital->creation_date))
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Digital  $digital
     * @return \Illuminate\Http\Response
     */
    public function edit(Digital $digital)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDigitalRequest  $request
     * @param  \App\Models\Digital  $digital
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDigitalRequest $request, Digital $digital)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Digital  $digital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Digital $digital)
    {
        //
    }
}
