<?php

namespace App\Models;

use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'status',
        'note',
    ];

    protected $casts = ['payment_date' => 'date', 'amount' => 'float'];

    protected $with = ['loan.member', 'meeting'];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    // Date Helper
    protected function getDateColumn(): string
    {
        return 'payment_date';
    }

    // Accessors
    public function statusLabel(): Attribute
    {
        return Attribute::get(fn(): string => match ($this->status) {
            'clear' => 'Clear',
            'skip' => 'Skip',
            default => '-',
        });
    }

    public function statusColor(): Attribute
    {
        return Attribute::get(fn(): string => match ($this->status) {
            'clear' => 'green',
            'skip' => 'amber',
            default => 'zinc',
        });
    }

    public function methodLabel(): Attribute
    {
        return Attribute::get(fn(): string => match ($this->method) {
            'cash' => 'Cash',
            'transfer' => 'Transfer',
            'qris' => 'QRIS',
            default => '-',
        });
    }

    public function methodColor(): Attribute
    {
        return Attribute::get(fn(): string => match ($this->method) {
            'cash' => 'lime',
            'transfer' => 'cyan',
            'qris' => 'fuchsia',
            default => 'zinc',
        });
    }

    // Search Scope
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('place', 'like', "%{$search}%")
                    ->orWhere('meeting_date', 'like', "%{$search}%");
            });
        });
    }

    // Model Events
    protected static function booted(): void
    {
        // Status Payment
        static::creating(function (Payment $payment) {
            $payment->status = $payment->amount > 0
                ? 'clear'
                : 'skip';
        });

        static::updating(function (Payment $payment) {
            $payment->status = $payment->amount > 0
                ? 'clear'
                : 'skip';
        });

        // Setelah Payment dibuat
        static::created(function (Payment $payment) {
            $payment->loan?->recalculate();
            $payment->loan?->createOverdueLoanIfNeeded();
        });

        // Setelah Payment diubah
        static::updated(function (Payment $payment) {
            $payment->loan?->recalculate();
            $payment->loan?->createOverdueLoanIfNeeded();
        });

        // Setelah Payment dihapus
        static::deleted(function (Payment $payment) {
            $payment->loan?->recalculate();
        });
    }
}
