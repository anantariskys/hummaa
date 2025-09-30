<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBankCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Satu kategori memiliki banyak soal.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'category_id');
    }

    public function tryouts()
    {
        return $this->hasMany(Tryout::class, 'category_id');
    }
}
