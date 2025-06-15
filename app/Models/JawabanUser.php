<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanUser extends Model
{
    use HasFactory;

    protected $table = 'jawaban_users'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'kuis_id',
        'jawaban',
        'benar',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kuis
    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }
}