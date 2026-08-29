<?php

namespace App\Models;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerNotification extends Model
{
    protected $fillable = [
        'member_id',
        'loan_id',
        'payment_id',
        'meeting_id',
        'type',
        'message',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => NotificationType::class,
            'sent_at' => 'datetime',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }
}
