<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regency;

class HomeController extends Controller
{
    public function index() {
        $regency = Regency::all();

        return view('home', compact('regency'));
    }
}
