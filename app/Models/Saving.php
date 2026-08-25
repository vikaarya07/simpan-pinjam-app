<?php

namespace App\Models;

use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    /** @use HasFactory<\Database\Factories\SavingFactory> */
    use HasFactory;
    use HasIndonesianDate;

    protected $fillable = [
        'transaction_date',
        'type',
        'debit',
        'credit',
        'interest_percent',
        'interest_amount',
        'balance',
        'receivable',
        'amount',
        'description',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'debit' => 'float',
        'credit' => 'float',
        'balance' => 'float',
        'receivable' => 'float',
        'amount' => 'float',
        'interest_percent' => 'float',
        'interest_amount' => 'float',
    ];

    public const TYPES = [
        'Opening',
        'Loan',
        'Loan Overdue',
        'Installment',
        'Assistance',
    ];

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'Opening' => 'Pembukaan',
            'Loan' => 'Pinjaman',
            'Loan Overdue' => 'Telat',
            'Installment' => 'Angsuran',
            'Assistance' => 'Bantuan',
            default => $this->type,
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'Opening' => 'zinc',
            'Assistance' => 'amber',
            'Loan' => 'blue',
            'Loan Overdue' => 'red',
            'Installment' => 'green',
            default => 'zinc',
        };
    }

    // Date Helper
    protected function getDateColumn(): string
    {
        return 'transaction_date';
    }

    // Search Scope
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
}
