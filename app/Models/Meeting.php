<?php

namespace App\Models;

use App\Models\Loan;
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
        'place'
    ];

    protected $casts = [
        'meeting_date' => 'date'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentSummary(): Attribute
    {
        return Attribute::get(function (): array {
            $loans = Loan::query()
                ->whereIn('type', ['loan', 'loan_overdue'])
                ->where('status', 'running')
                ->forMeeting($this)
                ->with([
                    'payments' => function ($query) {
                        $query->where('meeting_id', $this->id);
                    },
                ])
                ->get();

            $clear = 0;
            $unpaid = 0;
            $skip = 0;

            foreach ($loans as $loan) {
                $payment = $loan->payments->first();

                if (!$payment) {
                    $unpaid++;
                } elseif ($payment->status === 'clear') {
                    $clear++;
                } elseif ($payment->status === 'skip') {
                    $skip++;
                }
            }

            return [
                'clear' => $clear,
                'unpaid' => $unpaid,
                'skip' => $skip,
            ];
        });
    }

    protected function getDateColumn(): string
    {
        return 'meeting_date';
    }

    public function scopeSearch(Builder $query, ?string $search):Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('place', 'like', "%{$search}%")
                    ->orWhere('meeting_date', 'like', "%{$search}%");
            });
        });
    }
}
