<?php

namespace App\Models;

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
        'balance',
        'receivable',
        'amount',
        'description'
    ];

    protected $casts = [
        'transaction_date' => 'date'
    ];
}
