<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    const SPAM = 'spam';
    const PENDING = 'pending';
    const APPROVE = 'approve';

    protected $fillable = ['comment', 'ip_address'];


    // Boot method to hook into the model's lifecycle events
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Comment $comment) {
            $comment->user_id = auth()->id();
            $comment->ip_address = request()->ip();
        });
        static::updating(function (Comment $post) {
            $post->ip_address = request()->ip();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
