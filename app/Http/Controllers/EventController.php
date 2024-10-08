<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'user' => 'required',
            'id_prestadores' => 'required',
            'id_user' => 'required',
        ]);

        Event::create($request->all());

        return redirect()->back()->with('success', 'Evento criado com sucesso');
    }
}
