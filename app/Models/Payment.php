<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\CustomerNotification;
use App\Services\CustomerNotificationService;
use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'amount' => 'float',
            'status' => PaymentStatus::class,
            'method' => PaymentMethod::class,
        ];
    }

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

    public function notifications(): HasMany
    {
        return $this->hasMany(CustomerNotification::class);
    }

    // Date Helper
    protected function getDateColumn(): string
    {
        return 'payment_date';
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
        //  amount > 0  => Clear
        //  amount = 0  => Skip
        static::saving(function (Payment $payment) {
            $payment->status = $payment->amount > 0
                ? PaymentStatus::Clear
                : PaymentStatus::Skip;

            //  Skip tidak memiliki metode pembayaran.
            if ($payment->amount <= 0) {
                $payment->method = null;
            }
        });

        //  Setelah Payment dibuat.
        static::created(function (Payment $payment) {
            $payment->loan?->recalculate();
            $payment->loan?->createOverdueLoanIfNeeded();

            $service = app(CustomerNotificationService::class);

            $service->paymentReceived($payment);
            $service->almostPaidOff($payment->loan);
            $service->paidOff($payment->loan);
        });

        //   Setelah Payment diubah.
        static::updated(function (Payment $payment) {
            $payment->loan?->recalculate();
            $payment->loan?->createOverdueLoanIfNeeded();
        });

        //   Setelah Payment dihapus.
        static::deleted(function (Payment $payment) {
            $payment->loan?->recalculate();
        });
    }

    // Accessor
    protected function remainingAfterPayment(): Attribute
    {
        return Attribute::get(function (): float {
            $totalPaid = $this->loan
                ->payments()
                ->where(function ($query) {
                    $query
                        ->where('payment_date', '<', $this->payment_date)
                        ->orWhere(function ($query) {
                            $query
                                ->whereDate('payment_date', $this->payment_date)
                                ->where('id', '<=', $this->id);
                        });
                })
                ->sum('amount');

            return max(
                0,
                $this->loan->amount - $totalPaid
            );
        });
    }
}
