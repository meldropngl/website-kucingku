<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('register.index', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request){
       $validatedData = $request->validate([
            'username' => ['required', 'min:2', 'max:255', 'unique:users'],
            'password' => ['required', 'min:3', 'max:16'], 
            'confirm_password' => ['required','same:password']
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        $request->session()->flash('success', 'Registration successfull! Please login');
        return redirect('/login');
    }
}