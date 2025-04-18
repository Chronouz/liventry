<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class catatan extends Model
{
    use HasFactory;

    protected $table = 'catatan';

    protected $fillable = [
        'title',
        'content',
        'image_path',
        'entry_date',
        'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
