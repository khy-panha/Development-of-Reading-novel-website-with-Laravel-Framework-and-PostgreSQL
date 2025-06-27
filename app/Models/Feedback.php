<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Feedback extends Model
{
    use HasFactory;

    // Allow mass assignment for the name, email, subject, and message fields
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
    ];
}
