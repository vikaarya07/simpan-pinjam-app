<?php

namespace App\Models;

use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function typeLabel(): Attribute
    {
        return Attribute::get(fn(): string => match ($this->type) {
            'Opening' => 'Pembukaan',
            'Loan' => 'Pinjaman',
            'Loan Overdue' => 'Pinjaman Telat',
            'Installment' => 'Angsuran',
            'Assistance' => 'Bantuan',
            default => $this->type,
        });
    }

    public function typeColor(): Attribute
    {
        return Attribute::get(fn(): string => match ($this->type) {
            'Opening' => 'slate',
            'Assistance' => 'amber',
            'Loan' => 'indigo',
            'Loan Overdue' => 'rose',
            'Installment' => 'teal',
            default => 'zinc',
        });
    }

    // Date Helper
    protected function getDateColumn(): string
    {
        return 'transaction_date';
    }
}
