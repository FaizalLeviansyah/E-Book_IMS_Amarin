<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Mengizinkan semua kolom diisi kecuali ID

    // Satu Part punya banyak Chapter
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    // Satu Part itu milik satu Buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
