<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desain extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'judul', 'canvas_json', 'thumbnail_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
