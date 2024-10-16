<?php

namespace App\Http\Controllers;

use App\Models\Prestadores;
use App\Models\User;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index($empresa)
    {

        $company = Prestadores::where('url_marcacao', $empresa)->firstOrFail();
        // dd( $company["id"]);
        $users = User::where('id_prestadores', $company["id"])->get();

        return view('welcome', compact('users', 'company'));
    }
}
