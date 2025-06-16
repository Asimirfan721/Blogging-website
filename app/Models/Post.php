<?php
// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Post extends Model
{
    use HasFactory;

    // Define which attributes are mass assignable
    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'status',
        'category_id'
    ];

    /**
     * Get the user that owns the Post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category()
{
    return $this->belongsTo(Category::class);
}

}