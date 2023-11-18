<?php

namespace App\Http\Livewire;

use App\Models\Aktivitas;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AktivitasAbsen extends Component
{
    public $tanggal;
    public $kegiatan_id;
    public $has_selected_activity = false;
    
    // Validate user_id dynamically during the validation process
    protected $rules = [
        'tanggal' => 'required|date',
        'kegiatan_id' => 'required|exists:kegiatan,id',
    ];

    public function saveAktivitas()
    {
        // Dynamically set the user_id to the ID of the currently authenticated user
        $this->user_id = Auth::id();

        $this->validate();

        // Create a new Aktivitas record
        Aktivitas::create([
            'user_id' => $this->user_id,
            'tanggal' => $this->tanggal,
            'kegiatan_id' => $this->kegiatan_id,
        ]);

        // Update the variable after selecting the activity
        $this->has_selected_activity = true;

        // Redirect to the appropriate route and provide a success message
        return redirect()->route('home.show')->with('success', 'Aktivitas berhasil ditambahkan.');
    }

    public function render()
    {
        // Return the Livewire view
        return view('livewire.aktivitas-create');
    }
}
