<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'exhibitor_id',
        'name',
        'email',
        'phone_number',
        'whatsapp_number',
        'address',
        'profile_image',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'twitter_url',
        'bio',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship with exhibitor (Admin)
    public function exhibitor()
    {
        return $this->belongsTo(Admin::class, 'exhibitor_id');
    }

    // Accessor for profile image URL
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('assets/img/default-avatar.png');
    }
}
