<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    
    // Define the fillable fields
    protected $fillable = [
        'name',
        'email',
        'user_type',
        'password',
        'avatar',
        'address',
        'phone',
        'country_id',
        'university',
        'logo',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'twitter_url',
    ];

    // Relationship with Country
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class);
    }

    /**
     * Get the events associated with this exhibitor
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_exhibitor', 'exhibitor_id', 'event_id')
                    ->wherePivot('is_active', true)
                    ->withTimestamps();
    }

    /**
     * Get all events associated with this exhibitor (including inactive)
     */
    public function allEvents()
    {
        return $this->belongsToMany(Event::class, 'event_exhibitor', 'exhibitor_id', 'event_id')
                    ->withPivot('is_active', 'linked_at')
                    ->withTimestamps();
    }

    /**
     * Check if this admin is an exhibitor
     */
    public function isExhibitor()
    {
        return $this->user_type === 'exhibitor';
    }

    /**
     * Get the staff members for this exhibitor
     */
    public function staff()
    {
        return $this->hasMany(Staff::class, 'exhibitor_id');
    }

    /**
     * Get the appointments for this exhibitor
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'exhibitor_id');
    }
}
