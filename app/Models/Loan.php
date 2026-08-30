<?php

namespace App\Models;

use App\Enums\LoanStatus;
use App\Enums\LoanType;
use App\Enums\PaymentStatus;
use App\Models\CustomerNotification;
use App\Services\SavingService;
use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
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

    protected $with = [
        'member',
    ];

    protected function casts(): array
    {
        return [
            'loan_date' => 'date',
            'principal' => 'float',
            'interest_percent' => 'float',
            'interest_amount' => 'float',
            'amount' => 'float',
            'remaining' => 'float',
            'disbursement' => 'float',
            'type' => LoanType::class,
            'status' => LoanStatus::class,
        ];
    }

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

    public function overdueLoan()
    {
        return $this->hasOne(
            self::class,
            'previous_loan_id'
        );
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(CustomerNotification::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSearch(
        Builder $query,
        ?string $search
    ): Builder {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query
                    ->where(
                        'loan_number',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhereHas('member', function (Builder $query) use ($search) {
                        $query->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    })
                    ->orWhere(
                        'loan_date',
                        'like',
                        "%{$search}%"
                    );
            });
        });
    }

    public function scopeIsCustomer(Builder $query): Builder
    {
        return $query->whereIn('status', [
            LoanStatus::Running,
            LoanStatus::Finish,
            LoanStatus::Overdue,
        ]);
    }

    public function scopeRunning(Builder $query): Builder
    {
        return $query->where(
            'status',
            LoanStatus::Running
        );
    }

    public function scopeCanBePaid(Builder $query): Builder
    {
        return $query
            ->withCount('payments')
            ->having(
                'payments_count',
                '<',
                6
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Meeting
    |--------------------------------------------------------------------------
    |
    | Loan yang tampil pada Meeting:
    |
    | - Status running
    | - Pembayaran belum 6x
    | - Loan dibuat sebelum tanggal meeting
    | - Loan yang dibuat tepat pada hari meeting
    |   baru muncul pada meeting berikutnya
    |
    */

    public function scopeForMeeting(
        Builder $query,
        Meeting $meeting
    ): Builder {
        return $query
            ->running()
            ->canBePaid()
            ->with([
                'payments' => fn($q) => $q
                    ->where(
                        'meeting_id',
                        $meeting->id
                    ),
            ])
            ->whereDate(
                'loan_date',
                '<',
                $meeting->meeting_date
            );
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
    | Loan Calculation
    |--------------------------------------------------------------------------
    */

    public static function getInterestPercent(
        LoanType $type
    ): int {
        return match ($type) {
            LoanType::Loan => 5,
            LoanType::LoanOverdue => 10,
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

            /*
             * Jasa berdasarkan jenis loan.
             */
            $loan->interest_percent =
                self::getInterestPercent($loan->type);

            $loan->interest_amount =
                ($loan->principal * $loan->interest_percent) / 100;

            $loan->amount =
                $loan->principal + $loan->interest_amount;

            /*
             * Loan baru selalu mulai dari
             * total amount.
             */
            if (! $loan->exists) {
                $loan->remaining = $loan->amount;
            }

            /*
             * Status otomatis.
             *
             * Overdue dipertahankan selama
             * masih mempunyai sisa hutang.
             */
            if ($loan->remaining <= 0) {
                $loan->status = LoanStatus::Finish;
            } elseif ($loan->status !== LoanStatus::Overdue) {
                $loan->status = LoanStatus::Running;
            }

            /*
             * Loan Overdue tidak menghasilkan
             * pencairan uang baru.
             */
            if ($loan->type === LoanType::LoanOverdue) {

                $loan->disbursement = 0;
            } elseif ($loan->previousLoan) {

                $loan->disbursement = max(
                    0,
                    $loan->principal
                        - $loan->previousLoan->remaining
                );
            } else {

                $loan->disbursement = $loan->principal;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Create Overdue Loan
    |--------------------------------------------------------------------------
    */

    public function createOverdueLoanIfNeeded(): ?Loan
    {
        /*
         * Hanya Loan biasa yang dapat
         * berubah menjadi overdue.
         */
        if (
            $this->type !== LoanType::Loan
            || $this->payments()->count() < 6
            || $this->remaining <= 0
        ) {
            return null;
        }

        /*
         * Cek apakah overdue sudah dibuat.
         */
        $overdueExists = self::query()
            ->where(
                'previous_loan_id',
                $this->id
            )
            ->where(
                'type',
                LoanType::LoanOverdue
            )
            ->exists();

        if ($overdueExists) {
            return null;
        }

        /*
         * Buat Loan Overdue.
         */
        $overdue = self::create([
            'member_id' => $this->member_id,

            'previous_loan_id' => $this->id,

            'loan_number' => self::generateLoanNumber(),

            'loan_date' => now()->toDateString(),

            'type' => LoanType::LoanOverdue,

            /*
             * Maksimal sebesar sisa hutang.
             */
            'principal' => $this->remaining,

            /*
             * Field berikut sebenarnya akan
             * dihitung ulang oleh booted(),
             * tetapi tetap boleh dikirim.
             */
            'interest_percent' => 10,

            'interest_amount' =>
            $this->remaining * 10 / 100,

            'amount' =>
            $this->remaining * 1.10,

            'remaining' =>
            $this->remaining * 1.10,

            /*
             * Tidak ada pencairan uang baru.
             */
            'disbursement' => 0,

            'status' => LoanStatus::Running,
        ]);

        /*
         * Loan lama menjadi overdue.
         */
        $this->update([
            'status' => LoanStatus::Overdue,
        ]);

        /*
         * Catat Loan Overdue ke Saving.
         */
        app(SavingService::class)
            ->recordLoan($overdue);

        return $overdue;
    }

    /*
    |--------------------------------------------------------------------------
    | Loan Number
    |--------------------------------------------------------------------------
    */

    public static function generateLoanNumber(): string
    {
        $prefix = 'LN';

        $date = now()->format('Ymd');

        $lastLoan = self::query()
            ->whereDate(
                'created_at',
                today()
            )
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

    public function totalAmount(): Attribute
    {
        return Attribute::get(
            fn(): float => (float) $this->amount
        );
    }

    public function totalPaid(): Attribute
    {
        return Attribute::get(
            fn(): float => (float) $this->payments()->sum('amount')
        );
    }

    public function remainingAmount(): Attribute
    {
        return Attribute::get(
            fn(): float => max(
                0,
                $this->total_amount - $this->total_paid
            )
        );
    }

    /*
     * Payment pada meeting yang sedang dibuka.
     *
     * scopeForMeeting() sudah memfilter
     * relasi payments berdasarkan meeting.
     */
    public function currentPayment(): Attribute
    {
        return Attribute::get(
            fn(): ?Payment => $this->payments->first()
        );
    }

    public function isPaid(): Attribute
    {
        return Attribute::get(
            fn(): bool => $this->current_payment !== null
        );
    }

    public function nextPaymentCount(): Attribute
    {
        return Attribute::get(
            fn(): int => ($this->payments_count ?? $this->payments()->count()) + 1
        );
    }

    public function paymentProgress(): Attribute
    {
        return Attribute::get(
            fn(): string => ($this->payments_count ?? $this->payments()->count())
                . '/6'
        );
    }

    public function canPay(): Attribute
    {
        return Attribute::get(
            fn(): bool =>
            $this->status === LoanStatus::Running
                && (
                    $this->payments_count
                    ?? $this->payments()->count()
                ) < 6
        );
    }

    public function lastPayment(): Attribute
    {
        return Attribute::get(
            fn(): ?Payment =>
            $this->payments()
                ->latest('payment_date')
                ->first()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    public function recalculate(): void
    {
        $totalPaid = $this->payments()
            ->where('amount', '>', 0)
            ->sum('amount');

        $this->remaining = max(
            0,
            $this->amount - $totalPaid
        );

        $this->status = $this->remaining <= 0
            ? LoanStatus::Finish
            : LoanStatus::Running;

        $this->saveQuietly();
    }

    /*
    |--------------------------------------------------------------------------
    | Payment Status
    |--------------------------------------------------------------------------
    */
    protected function paymentStatus(): Attribute
    {
        return Attribute::get(
            fn(): ?PaymentStatus =>
            $this->current_payment?->status
        );
    }

    protected function hasOutstandingOverdue(): Attribute
    {
        return Attribute::get(
            fn(): bool =>
            $this->status === LoanStatus::Overdue
                && $this->remaining > 0
        );
    }
}
