<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    public function population()
    {
        $regencies = Regency::all();

        return view("tematik.population.index", compact("regencies"));
    }

    public function sekolah()
    {
        $regencies = Regency::all();

        return view("tematik.sekolah.index", compact("regencies"));
    }

    public function puskesmas()
    {
        $regencies = Regency::all();

        return view("tematik.puskesmas.index", compact("regencies"));
    }

}
