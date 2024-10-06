<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    public function edit($id)
    {
        return view('pages.editEmpresas', ['id' => $id]);
    }
    public function create()
    {
        return view('pages.addEmpresas');
    }
    public function index()
    {
        return view('pages.empresas');
    }
}
