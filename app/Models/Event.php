<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'url',
        'address',
        'city',
        'max_attendees',
        'is_featured',
        'registration_deadline',
        'image_url',
        'category_id',
        'organizer_id',
        'status',
        'color',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'registration_deadline' => 'datetime',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the event.
     */
    public function category()
    {
        return $this->belongsTo(category::class);
    }

    /**
     * Get the organizer that owns the event.
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * The users that are attending this event.
     */
    // public function attendees()
    // {
    //     return $this->belongsToMany(User::class, 'event_attendees')
    //         ->withPivot('registration_date', 'status', 'notes')
    //         ->withTimestamps();
    // }
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees')
            ->withTimestamps();
    }

    /**
     * Get the comments for the event.
     */


    /**
     * Scope a query to only include featured events.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>=', now());
    }

    /**
     * Scope a query to only include past events.
     */
    public function scopePast($query)
    {
        return $query->where('end_time', '<', now());
    }

    /**
     * Scope a query to only include today's events.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('start_time', now()->toDateString());
    }

    /**
     * Scope a query to only include this month's events.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('start_time', now()->month)
            ->whereYear('start_time', now()->year);
    }

    /**
     * Scope a query to filter by location.
     */
    public function scopeLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to only include active events.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the attendance count
     */
    public function getAttendanceCountAttribute()
    {
        return $this->attendees()->count();
    }

    /**
     * Check if event has available spots
     */
    public function getHasAvailableSpotsAttribute()
    {
        if (!$this->max_attendees) {
            return true;
        }

        return $this->attendance_count < $this->max_attendees;
    }

    /**
     * Check if event registration is still open
     */
    public function getIsRegistrationOpenAttribute()
    {
        if ($this->registration_deadline) {
            return now() <= $this->registration_deadline;
        }

        return $this->start_time > now();
    }

    /**
     * Convert the model to an array that can be used by FullCalendar
     */
    public function toCalendarArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->start_time->toIso8601String(),
            'end' => $this->end_time->toIso8601String(),
            'url' => '#', // Will be handled by JS
            'location' => $this->location,
            'category_id' => $this->category_id,
            'color' => $this->color ?: ($this->category ? $this->category->color : null),
            'textColor' => '#ffffff',
            'allDay' => $this->start_time->format('H:i:s') === '00:00:00' && $this->end_time->format('H:i:s') === '23:59:59',
        ];
    }
}
