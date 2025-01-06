<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $houses = Home::all();
        return view('houses.index', compact('houses'));
    }


}
