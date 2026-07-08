<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Baris ini wajib ada agar data bisa masuk ke tabel
    protected $guarded = ['id'];

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function forms() { return $this->hasMany(Form::class); }
}
