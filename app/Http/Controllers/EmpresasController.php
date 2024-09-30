<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    public function create()
    {
        return view('pages.addEmpresas');
    }
    public function index()
    {
        return view('pages.empresas');
    }
}
