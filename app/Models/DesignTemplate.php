<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignTemplate extends Model
{
    protected $fillable = [
        'supplier_id',
        'title',
        'description',
        'file_path',
        'example_link',
    ];
}