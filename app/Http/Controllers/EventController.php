<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Service;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'user' => 'required',
            'id_prestadores' => 'required',
            'id_user' => 'required',
            'service_ids' => 'required',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'id_services' => $request->service_ids,
            'user' => $request->user,
            'id_prestadores' => $request->id_prestadores,
            'id_user' => $request->id_user,
        ]);

        return redirect()->back()->with('success', 'Evento criado com sucesso');
    }
}
