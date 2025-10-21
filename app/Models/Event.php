<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected  $guarded = []; // event_type, zoom_link, qrcode_image are now mass assignable
    // New fields:
    // - event_type: string, 'physical' or 'virtual'
    // - zoom_link: nullable string
    // - qrcode_image: nullable string
    protected $casts = [
    'start_time' => 'datetime:Y-m-d H:i:s',
    'end_time' => 'datetime:Y-m-d H:i:s',
    'auto_approval' => 'boolean',
    ];

    protected $dates = [
        'start_time',
        'end_time',
        'created_at',
        'updated_at',
    ];

    public function sliderImages()
    {
        return $this->hasMany(EventSliderImage::class, 'event_id');
    }
    public function lineups()
    {
        return $this->hasMany(EventLineup::class, 'event_id');
    }
    public function agendas()
    {
        return $this->hasMany(EventAgenda::class, 'event_id');
    }
    public function faqs()
    {
        return $this->hasMany(EventFaq::class, 'event_id');
    }

    /**
     * Get the city that owns the event.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the exhibitors associated with this event
     */
    public function exhibitors()
    {
        return $this->belongsToMany(Admin::class, 'event_exhibitor', 'event_id', 'exhibitor_id')
                    ->where('user_type', 'exhibitor')
                    ->wherePivot('is_active', true)
                    ->withTimestamps();
    }

    /**
     * Get all exhibitors associated with this event (including inactive)
     */
    public function allExhibitors()
    {
        return $this->belongsToMany(Admin::class, 'event_exhibitor', 'exhibitor_id', 'event_id')
                    ->where('user_type', 'exhibitor')
                    ->withPivot('is_active', 'linked_at')
                    ->withTimestamps();
    }

    /**
     * Get the start time in the application timezone
     */
    public function getStartTimeAttribute($value)
    {
        if ($value) {
            return $this->asDateTime($value)->setTimezone(config('app.timezone'));
        }
        return $value;
    }

    /**
     * Get the end time in the application timezone
     */
    public function getEndTimeAttribute($value)
    {
        if ($value) {
            return $this->asDateTime($value)->setTimezone(config('app.timezone'));
        }
        return $value;
    }

    /**
     * Check if the event is upcoming (hasn't started yet)
     * Uses proper timezone comparison
     */
    public function isUpcoming()
    {
        $now = now();
        return $this->start_time && $this->start_time > $now;
    }

    /**
     * Check if the event is ongoing (currently happening)
     * Uses proper timezone comparison
     */
    public function isOngoing()
    {
        $now = now();
        $startTime = $this->start_time;
        $endTime = $this->end_time;
        
        return $startTime && $startTime <= $now && (!$endTime || $endTime >= $now);
    }

    /**
     * Check if the event is completed (has ended)
     * Uses proper timezone comparison
     */
    public function isCompleted()
    {
        $now = now();
        $endTime = $this->end_time;
        
        return $endTime && $endTime < $now;
    }

    /**
     * Get the status badge HTML
     */
    public function getStatusBadge()
    {
        if ($this->isUpcoming()) {
            return '<span class="badge bg-success">Upcoming</span>';
        } elseif ($this->isOngoing()) {
            return '<span class="badge bg-primary">Ongoing</span>';
        } else {
            return '<span class="badge bg-secondary">Completed</span>';
        }
    }

    /**
     * Get the status badge with custom styling
     */
    public function getStatusBadgeCustom()
    {
        if ($this->isUpcoming()) {
            return '<span class="event-status-badge upcoming">Upcoming</span>';
        } elseif ($this->isOngoing()) {
            return '<span class="event-status-badge ongoing">Live Now</span>';
        } else {
            return '<span class="event-status-badge completed">Completed</span>';
        }
    }

    /**
     * Scope a query to only include upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now());
    }

    /**
     * Scope a query to only include ongoing events
     */
    public function scopeOngoing($query)
    {
        $now = now();
        return $query->where('start_time', '<=', $now)
                    ->where(function($q) use ($now) {
                        $q->whereNull('end_time')
                          ->orWhere('end_time', '>=', $now);
                    });
    }

    /**
     * Scope a query to only include completed events
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('end_time')
                    ->where('end_time', '<', now());
    }
}
