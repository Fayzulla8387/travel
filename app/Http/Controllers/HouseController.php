<?php

namespace App\Http\Controllers;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
                $file = $request->file('image');
                $extension = strtolower($file->getClientOriginalExtension()); // Katta harflarni kichik qilib olish

                // Faqat ruxsat etilgan kengaytmalar
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $validated['image'] = $file->store('houses', 'public');
                } else {
                    return redirect()->back()->withErrors(['image' => 'Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.']);
                }
            }




            Home::create($validated);

            return redirect()->route('houses.index');
        }

    public function show(Home $house)
    {
        return redirect()->back();
    }

    // Controllerda `edit` metodini quyidagi tarzda yozing:
    public function edit(Home $house)
    {
        return view('houses.edit', compact('house'));
    }




// HomeControllerda `update` metodini quyidagicha yozing:
    public function update(Request $request, Home $house)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'size' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension()); // Katta harflarni kichik qilib olish

            // Faqat ruxsat etilgan kengaytmalar
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $validated['image'] = $file->store('houses', 'public');
            } else {
                return redirect()->back()->withErrors(['image' => 'Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.']);
            }
        }

        $house->update($validated);

        return redirect()->route('houses.index')->with('success', 'House updated successfully.');
    }


    public function destroy(Home $house)
    {
        $house->delete();
        return response()->json(['message' => 'House deleted successfully.']);
    }

}
