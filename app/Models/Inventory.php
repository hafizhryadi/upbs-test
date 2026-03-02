<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function variety()
    {
        return $this->belongsTo(Variety::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Determine seed status based on expiry date.
     * Uses 3 months as standard threshold for warning.
     */
    public static function getStatusData($expiryDate)
    {
        $expiry = \Carbon\Carbon::parse($expiryDate);
        $isExpired = $expiry->isPast();
        // Standardized to 3 months across the app
        $isNear = $expiry->lte(now()->addMonths(3)) && !$isExpired;

        if ($isExpired) {
            return [
                'status' => 'expired',
                'label' => 'Kadaluarsa',
                'badge' => 'danger'
            ];
        } elseif ($isNear) {
            return [
                'status' => 'warning',
                'label' => 'Mendekati Kadaluarsa',
                'badge' => 'warning'
            ];
        }

        return [
            'status' => 'safe',
            'label' => 'Aman',
            'badge' => 'success'
        ];
    }

    public function getExpiryStatusAttribute()
    {
        return self::getStatusData($this->expiry_date)['status'];
    }

    public function getExpiryStatusLabelAttribute()
    {
        return self::getStatusData($this->expiry_date)['label'];
    }

    public function getExpiryStatusBadgeAttribute()
    {
        return self::getStatusData($this->expiry_date)['badge'];
    }
}
