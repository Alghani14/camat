<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use App\Models\Permission;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;


class PermissionForm extends Component
{
    use WithFileUploads;

    public $permission;
    public $attendanceId;

    protected $rules = [
        'permission.judul' => 'required|string|min:6',
        'permission.deskripsi' => 'required|string|max:500',
        'permission.image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Menambahkan validasi untuk gambar (maksimum 2MB)
        'permission.start_date' => 'required|date',
        'permission.end_date' => 'required|date|after:permission.start_date', // Pastikan tanggal akhir setelah tanggal awal
        'permission.total_izin' => 'required|string|max:500',
    ];

    public function save()
    {
        $this->validate();

        $imagePath = $this->permission['image']->store('images', 'public'); // Simpan gambar ke direktori public/images

        Permission::create([
            "user_id" => auth()->user()->id,
            "attendance_id" => $this->attendanceId,
            "judul" => $this->permission['judul'],
            "deskripsi" => $this->permission['deskripsi'],
            "image" => $imagePath, // Simpan path gambar yang telah diunggah
            "start_date" => $this->permission['start_date'],
            "end_date" => $this->permission['end_date'],
            "total_izin" => $this->permission['total_izin'],
            "permission_date" => now()->toDateString(),
        ]);

        return redirect()->route('home.show', $this->attendanceId)->with('success', 'Permintaan izin sedang diproses. Silahkan tunggu...');
    }

    public function render()
    {
        return view('livewire.permission-form');
    }
}
