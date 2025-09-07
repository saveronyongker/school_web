<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruPktController extends Controller
{
     public function index()
    {
        return view('gurupkt.home_gurupkt');
    }
}
