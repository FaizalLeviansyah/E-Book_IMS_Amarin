<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['book_id', 'title', 'file_path', 'file_type'];
    public function book() { return $this->belongsTo(Book::class); }
}
