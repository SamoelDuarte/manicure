<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Services::all();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        Services::create($request->all());
        return redirect()->route('services.index')->with('success', 'Serviço criado com sucesso!');
    }

    public function edit(Services $servico)
    {
        return view('services.edit', compact('servico'));
    }

    public function update(Request $request, Services $servico)
    {
        $servico->update($request->all());
        return redirect()->route('services.index')->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroy(Services $servico)
    {
        $servico->delete();
        return redirect()->route('services.index')->with('success', 'Serviço excluído com sucesso!');
    }
}
