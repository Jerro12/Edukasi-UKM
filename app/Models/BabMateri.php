<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabMateri extends Model
{
    use HasFactory;

    // 👇 ini agar Laravel pakai tabel 'bab_materi', bukan 'bab_materis'
    protected $table = 'bab_materi';

    protected $fillable = ['judul_bab', 'deskripsi'];

    public function subMateri()
    {
        return $this->hasMany(MateriEdukasi::class, 'bab_materi_id');
    }
}
