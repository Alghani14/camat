<?php

namespace App\Http\Livewire;

use App\Models\Kegiatan;
use App\Models\Position;
use Livewire\Component;

class KegiatanCreate extends Component
{
    public $kegiatans = [];
    public $positions = [];

    protected function rules()
    {
        return [
            'kegiatans.*.aktivitas' => 'required|string',
            'kegiatans.*.position_id' => 'required|exists:positions,id',
        ];
    }

    public function mount()
    {
        $this->kegiatans = [['aktivitas' => '', 'position_id' => null]];
        $this->positions = Position::all();
    }

    public function addKegiatanInput(): void
    {
        $this->kegiatans[] = ['aktivitas' => '', 'position_id' => null];
    }

    public function removeKegiatanInput(int $index): void
    {
        unset($this->kegiatans[$index]);
        $this->kegiatans = array_values($this->kegiatans);
    }

    public function saveKegiatan()
    {
        $this->validate();

        foreach ($this->kegiatans as $activity) {
            Kegiatan::create($activity);
        }

        return redirect()->route('kegiatan.index')->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.kegiatan-create');
    }
}
