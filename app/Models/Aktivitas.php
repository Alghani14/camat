<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{

    protected $fillable = ['user_id', 'tanggal', 'kegiatan_id'];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function kegiatans()
    {
        return $this->belongsToMany(Kegiatan::class);
    }
    use HasFactory;
}
