<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'blog_id',
        'user_id',
        'comment',
        ];

        public function blog(): BelongsTo
        {
            return $this->belongsTo(Blog::class);
        }
        
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }

    
}
