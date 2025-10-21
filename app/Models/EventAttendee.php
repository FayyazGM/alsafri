<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendee extends Model
{
    use HasFactory;
    protected  $guarded = [];
    protected $casts = [
        'visited_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'timeslot_from' => 'datetime:H:i',
        'timeslot_to' => 'datetime:H:i',
        'auto_approved' => 'boolean',
    ];
    public function markedBy()
    {
        return $this->belongsTo(Admin::class, 'marked_by');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(Admin::class, 'rejected_by');
    }
}
