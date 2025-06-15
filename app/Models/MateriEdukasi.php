<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriEdukasi extends Model
{
    use HasFactory;

    protected $table = 'materi_edukasis'; // opsional, biar konsisten

    protected $fillable = [
        'judul',
        'deskripsi',
        'bab_materi_id', // ✅ ditambahkan
    ];

    // ✅ relasi ke BabMateri
    public function bab()
    {
        return $this->belongsTo(BabMateri::class, 'bab_materi_id');
    }
    public function babMateri()
    {
        return $this->belongsTo(\App\Models\BabMateri::class, 'bab_materi_id');
    }

    public function kuis()
    {
        return $this->hasMany(Kuis::class, 'materi_id');
    }
}