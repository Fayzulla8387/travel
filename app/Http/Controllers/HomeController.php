<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houses=Home::all();
            $feedbacks = Feedback::where('status', 1)->get();
        return view('index',[
            'houses' => $houses,
            'feedbacks' => $feedbacks
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        //
    }

    public function contact(){

        return view('contact');
    }
    public function about(){
        return view('about');
    }

    public function property_list(){
        $houses=Home::all();
        return view('property-list',[
            'houses'=>$houses
        ]);
    }

    public function property_type(){
        return view('property-type');
    }
    public function property_agent(){
        return view('property-agent');
    }


}
