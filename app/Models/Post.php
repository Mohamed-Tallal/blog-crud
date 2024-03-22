<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

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
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the comments for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
