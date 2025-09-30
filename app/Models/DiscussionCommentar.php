<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionCommentar extends Model
{
    use HasFactory;

    protected $table = 'discussion_commentar';

    protected $fillable = [
        'user_id',
        'discussion_id',
        'commentar',
    ];

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
