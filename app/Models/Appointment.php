<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'exhibitor_id',
        'attendee_id',
        'attendee_name',
        'attendee_email',
        'attendee_phone',
        'university',
        'message',
        'status',
        'appointment_date',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationship with Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relationship with Exhibitor (Admin)
    public function exhibitor()
    {
        return $this->belongsTo(Admin::class, 'exhibitor_id');
    }

    // Relationship with Attendee
    public function attendee()
    {
        return $this->belongsTo(EventAttendee::class, 'attendee_id');
    }

    // Status scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    // Get status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'info',
            default => 'secondary'
        };
    }
}
