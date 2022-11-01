<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class SessionController extends Controller
{
    public function destroy(){
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye');
    }

    public function store(){

        $attributes = request()->validate([
            'password' => ['required']
        ]);

        //dd(Auth::attempt(['email' => 'theriault.antoine@gmail.com', 'password' => 'Bitch328']));

        if(Auth::attempt(['email' => 'theriault.antoine@gmail.com', 'password' => $attributes['password']])){
            return redirect('admin/')->with('success', 'Bien Joué');
        }

        throw ValidationException::withMessages([
            'password' => 'Mauvais mot de passe...'
        ]);
    }

    public function create(){
        return Inertia::render('Admin/Login');
    }
}
