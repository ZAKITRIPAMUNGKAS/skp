<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, \App\Traits\Loggable;

    protected $fillable = [
        'title',
        'event_name',
        'image',
        'urutan',
    ];

    public function getImageUrlAttribute()
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        return $this->image ? asset('storage/' . $this->image) : asset('images/gallery/gallery_discussion.png');
    }
}
