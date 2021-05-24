<?php

namespace App\Modules\V1\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function contactUs()
    {
        return view('contact');
    }
}
