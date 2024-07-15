<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'slug', 'status', 'allow_comments'];
    const DRAFT = 'draft';
    const PENDING = 'pending';
    const PUBLISH = 'publish';


    // Boot method to hook into the model's lifecycle events
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Post $post) {
            $post->slug = $post->slug ?: Str::slug($post->title);
        });

        static::updating(function (Post $post) {
            $post->slug = $post->slug ?: Str::slug($post->title);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('status', self::PUBLISH);
    }
}
