<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function welcome()
    {
        if(auth()->user()){
           $user = auth()->user();
            return view('welcome',compact('user'));
        }
        return view('welcome');
    }
    public function contact()
    {
        if(auth()->user()){
            $user = auth()->user();
             return view('contact',compact('user'));
         }
        return view('contact');
    }
    public function services()
    {
        if(auth()->user()){
            $user = auth()->user();
             return view('services',compact('user'));
         }
        return view('services');
    }
    public function doctors()
    {
        if(auth()->user()){
            $user = auth()->user();
             return view('doctors',compact('user'));
         }
        return view('doctors');
    }
}
