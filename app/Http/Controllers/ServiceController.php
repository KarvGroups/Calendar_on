<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function indexHorarios()
    {
        return view('pages.horarios');
    }
    public function index()
    {
        return view('pages.category');
    }
}
