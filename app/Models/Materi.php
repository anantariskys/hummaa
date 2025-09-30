<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'title',
        'description',
        'status',
        'duration',
        'file_size',
        'progress',
        'file_path',
        'is_active'
    ];

    protected $casts = [
        'progress' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the file URL for the materi
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return Storage::url($this->file_path);
        }
        return null;
    }

    /**
     * Check if file exists
     */
    public function hasFile()
    {
        return $this->file_path && Storage::exists($this->file_path);
    }

    /**
     * Get progress percentage with % symbol
     */
    public function getProgressPercentageAttribute()
    {
        return $this->progress . '%';
    }

    /**
     * Check if materi is completed
     */
    public function isCompleted()
    {
        return $this->status === 'Selesai' || $this->progress >= 100;
    }

    /**
     * Check if materi is in progress
     */
    public function isInProgress()
    {
        return $this->status === 'Progres' && $this->progress > 0 && $this->progress < 100;
    }

    /**
     * Scope for active materi only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for completed materi
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Selesai');
    }

    /**
     * Scope for in progress materi
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'Progres');
    }
}