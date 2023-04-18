<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'description',
        'image',
        'artist_id',
        'category_id',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
