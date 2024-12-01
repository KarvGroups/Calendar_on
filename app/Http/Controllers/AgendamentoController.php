<?php

namespace App\Http\Controllers;

use App\Models\Prestadores;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    public function index($empresa)
    {

        $loggedUser = Auth::user();

        $company = Prestadores::where('url_marcacao', $empresa)->firstOrFail();

        $users = User::where('id_prestadores', $company["id"])->get();
        
        return view('welcome', compact('users', 'company'));
    }
}
