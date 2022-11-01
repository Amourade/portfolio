<?php

use App\Http\Controllers\AdminDigitalController;
use App\Http\Controllers\AdminDrawingController;
use App\Http\Controllers\AdminPaintingController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DigitalController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrawingController;
use App\Http\Controllers\PaintingController;
use App\Http\Controllers\ProjectController;
use Inertia\Inertia;
use App\Models\Digital;
use App\Models\Drawing;
use App\Models\Painting;
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
}); */

Route::get('/', function () {
    $paintings = Painting::all()->map(function($painting){
        $painting = [
            'title' => $painting->title,
            'slug' => '/peintures/'.$painting->slug,
            'image' => $painting->images[0]->medium,
            'date' => $painting->creation_date,
            'type' => 'painting'
        ];
        return $painting;
    });
    $drawings = Drawing::all()->map(function($drawing){
        $drawing = [
            'title' => $drawing->title,
            'slug' => '/dessins/'.$drawing->slug,
            'image' => $drawing->images[0]->medium,
            'date' => $drawing->creation_date,
            'type' => 'drawing'
        ];
        return $drawing;
    });
    $digitals = Digital::all()->map(function($digital){
        $digital = [
            'title' => $digital->title,
            'slug' => '/digitals/'.$digital->slug,
            'image'=> $digital->images[0]->medium,
            'date' => $digital->creation_date,
            'type' => 'digital'
        ];
        return $digital;
    });
    $projects = Project::all()->map(function($project){
        $project = [
            'title' => $project->title,
            'slug' => '/projets/'.$project->slug,
            'image' => $project->images[0]->medium,
            'date' => $project->creation_date,
            'type' => 'project'
        ];
        return $project;
    });

    $works = collect($paintings->concat($drawings)->concat($digitals)->concat($projects))->sortByDesc('date')->values()->all();

    return Inertia::render('Home', [
        'works' => $works
    ]);
});

Route::get('peintures/{painting:slug}', [PaintingController::class, 'show']);
Route::get('peintures', [PaintingController::class, 'index']);

Route::get('dessins/{drawing:slug}', [DrawingController::class, 'show']);
Route::get('dessins', [DrawingController::class, 'index']);

Route::get('digitaux/{digital:slug}', [DigitalController::class, 'show']);
Route::get('digitaux', [DigitalController::class, 'index']);

Route::get('projets', [ProjectController::class, 'index']);

Route::get('cv', function(){
    return Inertia::render('CV');
});

Route::get('a-propos', function(){
    return Inertia::render('About');
});

/* Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
 */
/**
 * Admin Routes
 */
Route::get('admin/login', [AuthenticatedSessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('admin/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::post('admin/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth');

Route::name('admin')->middleware(['auth', 'verified'])->group(function(){
    Route::get('admin', function(){
        return Inertia::render('Admin/Index');
    })->name('dashboard');
    Route::resource('admin/paintings', AdminPaintingController::class)->except('show');
    Route::resource('admin/drawings', AdminDrawingController::class)->except('show');
    Route::resource('admin/digitals', AdminDigitalController::class)->except('show');
    Route::resource('admin/projects', AdminProjectController::class)->except('show');
    
});

require __DIR__.'/auth.php';
