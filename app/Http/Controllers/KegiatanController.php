<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        return view('kegiatan.index');
    }

    public function create()
    {
        $title = "Your Page Title";
        return view('kegiatan.create', compact('title'));
       
    }
   
}
