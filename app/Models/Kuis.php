<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $fillable = [
        'materi_id',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar',
    ];

    public function materi()
    {
        return $this->belongsTo(MateriEdukasi::class, 'materi_id');
    }

    public function jawabanUser()
    {
        return $this->hasMany(JawabanUser::class);
    }
}