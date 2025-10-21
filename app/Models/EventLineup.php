<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLineup extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $fillable = [
        'event_id',
        'name',
        'image_path',
        'order',
        'sort'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('sort', 'asc');
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
} 