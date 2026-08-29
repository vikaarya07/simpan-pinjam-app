<?php

namespace App\Models;

use App\Enums\LoanType;
use App\Enums\PaymentStatus;
use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    /** @use HasFactory<\Database\Factories\MeetingFactory> */
    use HasFactory;
    use HasIndonesianDate;

    protected $fillable = [
        'meeting_date',
        'place',
    ];

    public function casts(): array
    {
        return [
            'meeting_date' => 'datetime',
        ];
    }

    //  Relationships
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Payment Summary
    protected function paymentSummary(): Attribute
    {
        return Attribute::get(function (): array {
            $loans = Loan::query()
                ->whereIn('type', [
                    LoanType::Loan,
                    LoanType::LoanOverdue,
                ])
                ->forMeeting($this)
                ->with([
                    'payments' => function ($query) {
                        $query->where(
                            'meeting_id',
                            $this->id
                        );
                    },
                ])
                ->get();

            $clear = 0;
            $skip = 0;
            $unpaid = 0;

            foreach ($loans as $loan) {
                $payment = $loan->payments->first();

                //   Belum ada Payment untuk meeting ini.
                if (! $payment) {
                    $unpaid++;
                    continue;
                }

                //  Payment sudah ada.

                match ($payment->status) {
                    PaymentStatus::Clear => $clear++,
                    PaymentStatus::Skip => $skip++,
                };
            }

            return [
                'clear' => $clear,
                'skip' => $skip,
                'unpaid' => $unpaid,
            ];
        });
    }

    //  Date Helper
    protected function getDateColumn(): string
    {
        return 'meeting_date';
    }

    //  Search Scope
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('place', 'like', "%{$search}%")
                    ->orWhere('meeting_date', 'like', "%{$search}%");
            });
        });
    }
}
