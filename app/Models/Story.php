<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'part',
        'story',
        'pdf_file',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function views()
    {
        return $this->hasMany(Views::class);
    }
}
