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
        return $this->belongsTo(Variety::class)->withTrashed();
    }

    public function location()
    {
        return $this->belongsTo(Location::class)->withTrashed();
    }

    /**
     * Determine seed status based on expiry date.
     * Uses 3 months as standard threshold for warning.
     */
    public static function getStatusData($expiryDate, $quantity = null)
    {
        if ($quantity !== null && $quantity <= 0) {
            return [
                'status' => 'empty',
                'label' => 'Stok Habis',
                'badge' => 'danger' // Use danger badge for empty stock
            ];
        }

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
        return self::getStatusData($this->expiry_date, $this->quantity)['status'];
    }

    public function getExpiryStatusLabelAttribute()
    {
        return self::getStatusData($this->expiry_date, $this->quantity)['label'];
    }

    public function getExpiryStatusBadgeAttribute()
    {
        return self::getStatusData($this->expiry_date, $this->quantity)['badge'];
    }
}
