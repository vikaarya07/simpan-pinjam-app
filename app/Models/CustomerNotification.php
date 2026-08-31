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
        'title',
        'message',
        'sent_at',
        'read_at',
    ];

    protected $with = ['loan', 'payment', 'meeting'];

    protected $casts = [
        'type' => NotificationType::class,
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | MEMBER
    |--------------------------------------------------------------------------
    */

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /*
    |--------------------------------------------------------------------------
    | LOAN
    |--------------------------------------------------------------------------
    */

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT
    |--------------------------------------------------------------------------
    */

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | MEETING
    |--------------------------------------------------------------------------
    */

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    /*
    |--------------------------------------------------------------------------
    | READ
    |--------------------------------------------------------------------------
    */

    public function markAsRead(): void
    {
        if ($this->read_at) {
            return;
        }

        $this->forceFill([
            'read_at' => now(),
        ])->save();
    }

    /*
    |--------------------------------------------------------------------------
    | SENT
    |--------------------------------------------------------------------------
    */

    public function markAsSent(): void
    {
        $this->forceFill([
            'sent_at' => now(),
        ])->save();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isRead(): bool
    {
        return filled($this->read_at);
    }

    public function isSent(): bool
    {
        return filled($this->sent_at);
    }
}
