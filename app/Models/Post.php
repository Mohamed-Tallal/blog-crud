<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title_en',
        'title_ar',
        'body_en',
        'body_ar',
    ];

    public function getImagePathAttribute($value): ?string
    {
        return self::makeFileUrl($this->image);
    }

    public function getTitleAttribute()
    {
        return self::getLocaleValue('title');
    }

    public function getBodyAttribute()
    {
        return self::getLocaleValue('body');
    }
}
