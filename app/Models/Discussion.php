<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'tryout_id',
        'title',
        'image',
        'user_id',
        'desc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(DiscussionCommentar::class, 'discussion_id');
    }

    public function latestComment()
    {
        return $this->hasOne(\App\Models\DiscussionCommentar::class, 'discussion_id')->latestOfMany();
    }
}
