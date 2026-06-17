<?php

namespace App\Models;


use App\Models\Member;
use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory;
    use HasIndonesianDate;

    protected $fillable = [
        'member_id',
        'slug',
        'loan_number',
        'loan_date',
        'type',
        'principal',
        'interest_percent',
        'interest_amount',
        'amount',
        'remaining',
        'status'
    ];

    protected $casts = [
        'loan_date' => 'date'
    ];

    protected $with = ['member'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where('loan_number', 'like', "%{$search}%")
                ->orWhereHas('member', function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('npk', 'like', "%{$search}%");
                });
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($loan) {
            if (empty($loan->slug)) {
                $loan->slug = Str::slug($loan->loan_number . '-' . time());
            }
        });
    }

    protected static function booted()
    {
        static::saving(function ($loan) {
            $loan->interest_percent = match ($loan->type) {
                'loan_overdue' => 10,
                default => 5,
            };

            $loan->interest_amount = ($loan->principal * $loan->interest_percent) / 100;
            $loan->amount = $loan->principal + $loan->interest_amount;
            $loan->remaining = $loan->remaining ?? $loan->principal + $loan->interest_amount;
        });
    }

    public static function generateLoanNumber(): string
    {
        $prefix = 'LN';
        $date = now()->format('Ymd');

        $lastLoan = self::whereDate('created_at', now()->toDateString())
            ->orderByDesc('id')
            ->first();

        if (! $lastLoan) {
            return "{$prefix}-{$date}-00001";
        }

        $lastNumber = (int) substr($lastLoan->loan_number, -5);
        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        return "{$prefix}-{$date}-{$nextNumber}";
    }
}
