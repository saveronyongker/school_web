<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestUser extends Model
{
    use HasFactory;

    // Tambahkan ini
    protected $fillable = [
        'name',
        'email',
        'password',

    ];
}