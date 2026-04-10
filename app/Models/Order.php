<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'description',
        'total_amount',
        'deposit_amount',
        'balance_amount',
        'status',
        'order_date',
        'estimated_ready_date',
        'actual_ready_date',
        'delivered_date',
        'delivery_required',
        'delivery_address',
        'special_instructions'
    ];

    protected $casts = [
        'order_date' => 'date',
        'estimated_ready_date' => 'date',
        'actual_ready_date' => 'date',
        'delivered_date' => 'date',
        'delivery_required' => 'boolean',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity', 'price_at_time', 'customizations')
            ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'materials_ordered', 'production', 'quality_check']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'delivered');
    }

    // Helper Methods
    public function getProgressPercentage()
    {
        $statusMap = [
            'pending' => 0,
            'materials_ordered' => 20,
            'production' => 50,
            'quality_check' => 75,
            'ready' => 90,
            'delivered' => 100,
            'cancelled' => 0,
        ];
        return $statusMap[$this->status] ?? 0;
    }

    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'materials_ordered' => 'bg-blue-100 text-blue-800',
            'production' => 'bg-purple-100 text-purple-800',
            'quality_check' => 'bg-indigo-100 text-indigo-800',
            'ready' => 'bg-green-100 text-green-800',
            'delivered' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function updateBalance()
    {
        $paid = $this->payments()->where('status', 'completed')->sum('amount');
        $this->balance_amount = $this->total_amount - $paid;
        $this->save();
    }
}