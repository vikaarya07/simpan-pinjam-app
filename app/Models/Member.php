<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\MemberStatus;
use App\Models\CustomerNotification;
use App\Models\Payment;
use App\Traits\HasIndonesianDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    use HasIndonesianDate;

    protected $fillable = [
        'npk',
        'name',
        'email',
        'phone',
        'gender',
        'date_birth',
        'date_join',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date_birth' => 'date',
            'date_join' => 'date',
            'gender' => Gender::class,
            'status' => MemberStatus::class,
        ];
    }

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customerNotifications()
    {
        return $this->hasMany(CustomerNotification::class);
    }

    protected function getDateColumn(): string
    {
        return 'date_join';
    }

    // Search Scope
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('npk', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'Active');
    }

    public static function generateNpk(): string
    {
        $lastMember = self::orderByDesc('npk')->first();

        if (! $lastMember) {
            return 'S001';
        }

        $lastNumber = (int) substr($lastMember->npk, 1);

        return 'S' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    // Accessors
    public function statusLabel(): Attribute
    {
        return Attribute::get(fn(): string => match ($this->status) {
            'Active' => 'Aktif',
            'Inactive' => 'Tidak Aktif',
            default => $this->status,
        });
    }

    public function statusColor(): Attribute
    {
        return Attribute::get(fn(): string => match ($this->status) {
            'Active' => 'green',
            'Inactive' => 'slate',
            default => 'zinc',
        });
    }

    public function age(): Attribute
    {
        return Attribute::get(fn(): ?int => $this->date_birth
            ? Carbon::parse($this->date_birth)->age
            : null);
    }
}
