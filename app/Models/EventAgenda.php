<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAgenda extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $fillable = [
        'event_id',
        'start_time',
        'end_time',
        'title',
        'username',
        'user_image',
        'description',
        'order',
        'sort'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
} 