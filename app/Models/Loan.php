<?php

namespace App\Models;

use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory;
    use HasIndonesianDate;

    protected $fillable = [
        'member_id',
        'loan_number',
        'previous_loan_id',
        'loan_date',
        'type',
        'principal',
        'interest_percent',
        'interest_amount',
        'amount',
        'remaining',
        'disbursement',
        'status',
    ];

    protected $casts = [
        'loan_date'         => 'date',
        'principal'         => 'float',
        'interest_percent'  => 'float',
        'interest_amount'   => 'float',
        'amount'            => 'float',
        'remaining'         => 'float',
        'disbursement'      => 'float',
    ];

    protected $with = ['member'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function previousLoan()
    {
        return $this->belongsTo(
            self::class,
            'previous_loan_id'
        );
    }

    public function nextLoans()
    {
        return $this->hasMany(
            self::class,
            'previous_loan_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Search Scope
    |--------------------------------------------------------------------------
    */

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query->where('loan_number', 'like', "%{$search}%")
                    ->orWhereHas('member', function (Builder $query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('npk', 'like', "%{$search}%");
                    });
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scope
    |--------------------------------------------------------------------------
    */

    public function scopeRunning($query)
    {
        return $query->where(
            'status',
            'running'
        );
    }

    public function scopeCanBePaid($query)
    {
        return $query
            ->withCount('payments')
            ->having('payments_count', '<', 6);
    }

    /**
     * Loan yang harus tampil pada Meeting.
     *
     * Rule:
     * - Status masih running
     * - Pembayaran belum 6x
     * - Loan dibuat sebelum tanggal meeting
     * - Loan yang dibuat tepat pada hari meeting
     *   baru muncul pada meeting berikutnya
     */
    public function scopeForMeeting(Builder $query, Meeting $meeting): Builder
    {
        return $query
            ->running()
            ->canBePaid()
            ->with([
                'payments' => fn($q) => $q
                    ->where('meeting_id', $meeting->id),
            ])
            ->whereDate('loan_date', '<', $meeting->meeting_date);
    }

    /*
    |--------------------------------------------------------------------------
    | Date Helper
    |--------------------------------------------------------------------------
    */

    protected function getDateColumn(): string
    {
        return 'loan_date';
    }

        /*
    |--------------------------------------------------------------------------
    | Interest Helper
    |--------------------------------------------------------------------------
    */

    /**
     * Mengambil persentase bunga berdasarkan jenis pinjaman.
     */
    public static function getInterestPercent(string $type): int
    {
        return match ($type) {
            'loan_overdue' => 10,
            default => 5,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::saving(function (Loan $loan) {

            // Tentukan bunga otomatis berdasarkan jenis pinjaman
            $loan->interest_percent = self::getInterestPercent($loan->type);

            // Hitung nominal bunga
            $loan->interest_amount = ($loan->principal * $loan->interest_percent) / 100;

            // Total pinjaman
            $loan->amount = $loan->principal + $loan->interest_amount;

            // Saat create, remaining = amount
            if (! $loan->exists) {
                $loan->remaining = $loan->amount;
            }

            // Status otomatis
            $loan->status = $loan->remaining <= 0 ? 'finish' : 'running';

            // Disbursement (uang yang benar-benar dicairkan)
            if ($loan->previousLoan) {
                $loan->disbursement = max(0, $loan->principal - $loan->previousLoan->remaining);
            } else {
                $loan->disbursement = $loan->principal;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Loan Number Generator
    |--------------------------------------------------------------------------
    */

    public static function generateLoanNumber(): string
    {
        $prefix = 'LN';
        $date = now()->format('Ymd');

        $lastLoan = self::query()
            ->whereDate('created_at', today())
            ->latest('id')
            ->first();

        if (! $lastLoan) {
            return "{$prefix}-{$date}-00001";
        }

        $lastNumber = (int) substr(
            $lastLoan->loan_number,
            -5
        );

        return sprintf(
            '%s-%s-%05d',
            $prefix,
            $date,
            $lastNumber + 1
        );
    }

        /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Total pinjaman (Pokok + Jasa)
     */
    public function getTotalAmountAttribute(): float
    {
        return (float) $this->amount;
    }

    /**
     * Total pembayaran yang sudah dilakukan.
     */
    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    /**
     * Sisa hutang sebenarnya.
     */
    public function getRemainingAmountAttribute(): float
    {
        return max(0, $this->total_amount - $this->total_paid);
    }

    /**
     * Pembayaran pada meeting yang sedang dibuka.
     *
     * Scope forMeeting() sudah memfilter relasi payments,
     * sehingga cukup mengambil payment pertama.
     */
    public function getCurrentPaymentAttribute(): ?Payment
    {
        return $this->payments->first();
    }

    /**
     * Sudah membayar pada meeting ini?
     */
    public function getIsPaidAttribute(): bool
    {
        return $this->current_payment !== null;
    }

    /**
     * Cicilan berikutnya.
     */
    public function getNextPaymentCountAttribute(): int
    {
        return ($this->payments_count ?? $this->payments()->count()) + 1;
    }

    /**
     * Progress pembayaran.
     *
     * Contoh:
     * 0/6
     * 3/6
     * 6/6
     */
    public function getPaymentProgressAttribute(): string
    {
        $count = $this->payments_count ?? $this->payments()->count();

        return "{$count}/6";
    }

    /**
     * Masih boleh melakukan pembayaran.
     */
    public function getCanPayAttribute(): bool
    {
        $count = $this->payments_count ?? $this->payments()->count();

        return $this->status === 'running' && $count < 6;
    }

    /**
     * Pembayaran terakhir.
     */
    public function getLastPaymentAttribute(): ?Payment
    {
        return $this->payments()
            ->latest('payment_date')
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    /**
     * Hitung ulang sisa hutang setelah ada perubahan payment.
     */
    public function recalculate(): void
    {
        $remaining = max(
            0,
            $this->amount - $this->payments()->sum('amount')
        );

        $this->update([
            'remaining' => $remaining,
            'status'    => $remaining <= 0
                ? 'finish'
                : 'running',
        ]);
    }
}
