<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ========== RELATIONSHIPS ==========

    /**
     * Orders placed by this customer
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * Tasks assigned to this carpenter
     */
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'carpenter_id');
    }

    /**
     * Deliveries assigned to this driver
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'driver_id');
    }

    /**
     * Issues reported by this user
     */
    public function reportedIssues()
    {
        return $this->hasMany(Issue::class, 'reported_by');
    }

    /**
     * Issues resolved by this user
     */
    public function resolvedIssues()
    {
        return $this->hasMany(Issue::class, 'resolved_by');
    }

    // ========== ROLE CHECKS ==========

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isCarpenter()
    {
        return $this->role === 'carpenter';
    }

    public function isDelivery()
    {
        return $this->role === 'delivery';
    }

    // ========== SCOPES ==========

    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeCarpenters($query)
    {
        return $query->where('role', 'carpenter');
    }

    public function scopeDeliveryStaff($query)
    {
        return $query->where('role', 'delivery');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
}