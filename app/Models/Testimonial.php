<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, \App\Traits\Loggable;

    protected $fillable = [
        'name',
        'role',
        'quote',
        'photo',
        'urutan',
    ];

    public function getPhotoUrlAttribute()
    {
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/testimonials/testimonial_1.png');
    }
}
