<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Satu Chapter punya banyak SubChapter
    public function subChapters()
    {
        return $this->hasMany(SubChapter::class);
    }

    // Satu Chapter itu milik satu Part
    public function part()
    {
        return $this->belongsTo(Part::class);
    }
}
