<?php

namespace App\Models;

use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    use HasIndonesianDate;

    protected $fillable = [
        'loan_id',
        'meeting_id',
        'amount',
        'payment_date',
        'payment_count',
        'method',
        'note',
    ];

    protected $casts = ['payment_date' => 'date', 'amount' => 'float'];

    protected $with = ['loan.member', 'meeting'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Date Helper
    |--------------------------------------------------------------------------
    */

    protected function getDateColumn(): string
    {
        return 'payment_date';
    }

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->whereHas('loan.member', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('npk', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::created(function ($payment) {
            $payment->loan->recalculate();
        });

        static::updated(function ($payment) {
            $payment->loan->recalculate();
        });

        static::deleted(function ($payment) {
            $payment->loan->recalculate();
        });
    }
}
