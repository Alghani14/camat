<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Presence;
use Livewire\Component;

class PresenceForm extends Component
{
    public Attendance $attendance;
    public $holiday;
    public $data;
   
    public function mount(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    // NOTED: setiap method send presence agar lebih aman seharusnya menggunakan if statement seperti diviewnya

    public function sendEnterPresence()
    {
        if ($this->attendance->data->is_start && !$this->attendance->data->is_using_qrcode) {
            Presence::create([
                "user_id" => auth()->user()->id,
                "attendance_id" => $this->attendance->id,
                "presence_date" => now()->toDateString(),
                "presence_enter_time" => now()->toTimeString(),
                "presence_out_time" => null
            ]);

            // untuk refresh if statement
            $this->data['is_has_enter_today'] = true;
            $this->data['is_not_out_yet'] = true;

            return $this->dispatchBrowserEvent('showToast', ['success' => true, 'message' => "Kehadiran atas nama '" . auth()->user()->name . "' berhasil dikirim."]);
        } else {
            return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => "Tidak dapat melakukan absensi masuk saat ini."]);
        }
    }

    public function sendOutPresence()
    {
        // jika absensi sudah jam pulang (is_end) dan tidak menggunakan qrcode (kebalikan)
        if (!$this->attendance->data->is_end && $this->attendance->data->is_using_qrcode) {
            return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => "Tidak dapat melakukan absensi pulang saat ini."]);
        }

        $presence = Presence::query()
            ->where('user_id', auth()->user()->id)
            ->where('attendance_id', $this->attendance->id)
            ->where('presence_date', now()->toDateString())
            ->where('presence_out_time', null)
            ->first();

        if (!$presence) {
            return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => "Tidak ditemukan catatan kehadiran yang sesuai."]);
        }

        // untuk refresh if statement
        $this->data['is_not_out_yet'] = false;
        $presence->update(['presence_out_time' => now()->toTimeString()]);
        return $this->dispatchBrowserEvent('showToast', ['success' => true, 'message' => "Atas nama '" . auth()->user()->name . "' berhasil melakukan absensi pulang."]);
    }

    public function selectActivity()
    {
        // Lakukan logika pemilihan aktivitas di sini
        // Misalnya, simpan ke database atau lakukan tindakan lainnya sesuai kebutuhan

        // Setelah berhasil memilih aktivitas, ubah nilai $activitySelected menjadi true
        $this->activitySelected = true;
    }
    public function render()
    {
        return view('livewire.presence-form');
    }
}
