<?php

namespace App\Models;

use App\Enums\SavingType;
use App\Traits\HasIndonesianDate;
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

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'debit' => 'float',
            'credit' => 'float',
            'balance' => 'float',
            'receivable' => 'float',
            'amount' => 'float',
            'interest_percent' => 'float',
            'interest_amount' => 'float',
            'type' => SavingType::class,
        ];
    }

    // Date Helper
    protected function getDateColumn(): string
    {
        return 'transaction_date';
    }
}
