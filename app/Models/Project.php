<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'additional_content',
        'conclusion',
        'category',
        'featured_image_path',
        'secondary_image_path',
        'gallery_images',
        'features',
        'progress_data',
        'client_name',
        'project_location',
        'project_date',
        'project_duration',
        'project_value',
        'sort_order',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'features' => 'array',
        'progress_data' => 'array',
        'project_date' => 'date',
        'project_value' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('title') && empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    /**
     * Scope for active projects
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured projects
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordered projects
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Get the featured image URL
     */
    public function getFeaturedImageUrlAttribute()
    {
        return asset('storage/' . $this->featured_image_path);
    }

    /**
     * Get the secondary image URL
     */
    public function getSecondaryImageUrlAttribute()
    {
        if ($this->secondary_image_path) {
            return asset('storage/' . $this->secondary_image_path);
        }
        return null;
    }

    /**
     * Get formatted project value
     */
    public function getFormattedProjectValueAttribute()
    {
        if ($this->project_value) {
            return 'SR ' . number_format($this->project_value, 2);
        }
        return null;
    }

    /**
     * Get formatted project date
     */
    public function getFormattedProjectDateAttribute()
    {
        if ($this->project_date) {
            return $this->project_date->format('F Y');
        }
        return null;
    }

    /**
     * Get related projects by category
     */
    public function getRelatedProjects($limit = 3)
    {
        return static::active()
            ->where('category', $this->category)
            ->where('id', '!=', $this->id)
            ->ordered()
            ->limit($limit)
            ->get();
    }

    /**
     * Get all unique categories
     */
    public static function getCategories()
    {
        return static::active()
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();
    }
}