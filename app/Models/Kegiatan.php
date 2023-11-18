<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    
    protected $fillable = ['aktivitas','position_id'];
    
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
