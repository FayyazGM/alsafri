<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ExhibitorMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'exhibitor_id',
        'event_id',
        'title',
        'media_type',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship with Exhibitor (Admin)
    public function exhibitor()
    {
        return $this->belongsTo(Admin::class, 'exhibitor_id');
    }

    // Relationship with Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Get file URL
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    // Get file size in human readable format
    public function getFileSizeHumanAttribute()
    {
        if (!$this->file_size) {
            return 'Unknown';
        }

        $bytes = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Check if file is video
    public function isVideo()
    {
        return $this->media_type === 'video';
    }

    // Check if file is brochure
    public function isBrochure()
    {
        return $this->media_type === 'brochure';
    }

    // Check if file is general file
    public function isFile()
    {
        return $this->media_type === 'file';
    }
}
