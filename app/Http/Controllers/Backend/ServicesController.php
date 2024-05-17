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
        return view('backend.service.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'duration_minutes' => 'required|integer'
        ]);

        Services::create($request->all());
        return redirect()->route('services.index');
    }

    public function update(Request $request, Services $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'duration_minutes' => 'required|integer'
        ]);

        $service->update($request->all());
        return redirect()->route('services.index');
    }
}