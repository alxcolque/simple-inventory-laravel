<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $clients = Client::where('name', 'like', '%'.$search.'%')->paginate(10);
        return view('clients.index', compact('clients','search'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(ClientRequest $request)
    {
        $client = $request->all();
        Client::create($client);
        return redirect()->route('users.index')->with('success', 'Cliente creado con éxito');
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, $id)
    {
        $client = Client::find($id);
        $client->update($request->all());
        return redirect()->route('clients.index')->with('success', 'Cliente actualizado con éxito');
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado con éxito');
    }
}
