<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'driver_id',
        'delivery_number',
        'customer_name',
        'customer_phone',
        'delivery_address',
        'latitude',
        'longitude',
        'scheduled_date',
        'time_slot',
        'actual_departure_time',
        'actual_arrival_time',
        'otp_code',
        'proof_photo',
        'delivery_notes',
        'status',
        'delivered_at'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'delivered_at' => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'assigned', 'en_route']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'delivered');
    }

    // Helper Methods
    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'assigned' => 'bg-blue-100 text-blue-800',
            'en_route' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'rescheduled' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}