<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index()
    {
        $houses = Home::all();
        return view('houses.index', compact('houses'));
    }

    public function create()
    {
        return view('houses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
            'size' => 'required|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('houses');
        }

        Home::create($validated);

        return redirect()->route('houses.index');
    }

    public function show(Home $house)
    {
        return view('houses.show', compact('house'));
    }

    public function edit(Home $house)
    {
        return response()->json([
            'id' => $house->id,
            'address' => $house->address,
            'price' => $house->price,
            'size' => $house->size,
            'bedrooms' => $house->bedrooms,
            'bathrooms' => $house->bathrooms,
            'description' => $house->description,
        ]);
    }


    public function update(Request $request, Home $house)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
            'size' => 'required|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('houses');
        }

        $house->update($validated);

        return redirect()->route('houses.index');
    }

    public function destroy(Home $house)
    {
        $house->delete();

        return redirect()->route('houses.index');
    }
}
