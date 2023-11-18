<?php

namespace App\Http\Livewire;

use App\Models\Aktivitas;
use App\Models\Kegiatan;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AktivitasCreate extends Component
{
    public $users = [];
    public $kegiatans = [];
    public $aktivitass = [];

    // Define the validation rules
    protected $rules = [
        'aktivitass.*.tanggal' => 'required|date_format:Y-m-d',
        'aktivitass.*.kegiatan_id' => 'required|exists:kegiatans,id',
    ];

    public function mount()
    {
        $this->users = User::all();
        $this->kegiatans = Kegiatan::all();
        $this->addAktivitasInput(); // Ensure at least one input is available initially
    }

    public function addAktivitasInput(): void
    {
        $defaultUserId = Auth::id();
        $defaultUserName = Auth::user()->name;

        $this->aktivitass[] = [
            'user_id' => $defaultUserId,
            'user_name' => $defaultUserName,
            'tanggal' => '',
            'kegiatan_id' => null,
        ];
    }

    public function removeAktivitasInput(int $index): void
    {
        unset($this->aktivitass[$index]);
        $this->aktivitass = array_values($this->aktivitass);
        $this->validate(); // Validate after removing an input
    }

    public function saveAktivitas()
    {
        $this->validate();

        foreach ($this->aktivitass as $activity) {
            Aktivitas::create($activity);
        }

        session()->flash('success', 'Data absensi berhasil ditambahkan.');
        return redirect()->route('aktivitas.index');
    }

    public function render()
    {
        return view('livewire.aktivitas-create');
    }
}
