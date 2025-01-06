<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::all();
        return view('feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $feedback=new Feedback();
        $feedback->client_name=$request->client_name;
        $feedback->client_email=$request->client_email;
        $feedback->subject=$request->subject;
        $feedback->message=$request->message;
        $feedback->status=0; // Tasdiqlanmagan statusda qolgan feedbacklar
        $feedback->save();

        return back()->with('success','Admin tasdiqlagandan so\'ng ko\'rishingiz mumkin asosiy sahifada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id); // Yozuvni topish
        $feedback->delete(); // Yozuvni o'chirish

        return redirect()->route('feedbacks.index')->with('success', 'Feedback o\'chirildi!');
    }

    public function approve($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->status = 1; // Tasdiqlash
        $feedback->save();

        return redirect()->route('feedbacks.index')->with('success', 'Feedback tasdiqlandi!');
    }


}
