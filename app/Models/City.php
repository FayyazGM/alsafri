<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'province',
        'is_major'
    ];

    protected $casts = [
        'is_major' => 'boolean',
    ];

    /**
     * Get the events for the city.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Scope to get only major cities
     */
    public function scopeMajor($query)
    {
        return $query->where('is_major', true);
    }

    /**
     * Scope to get cities by province
     */
    public function scopeByProvince($query, $province)
    {
        return $query->where('province', $province);
    }
}