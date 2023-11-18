<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = Aktivitas::all(); // Sesuaikan dengan cara Anda menarik data aktivitas
        return view('aktivitas.index', compact('aktivitas'));
    }

    
}
