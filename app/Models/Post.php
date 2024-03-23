<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Trait\GetsFileUrl;
use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, GetsFileUrl,HasLocaleValue,SoftDeletes;

    protected $fillable = [
        'image',
        'title_en',
        'title_ar',
        'body_en',
        'body_ar',
        'user_id'
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
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the comments for the Post
     *
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
