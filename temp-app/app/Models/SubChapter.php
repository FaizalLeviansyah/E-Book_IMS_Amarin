<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubChapter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Satu SubChapter itu milik satu Chapter
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
