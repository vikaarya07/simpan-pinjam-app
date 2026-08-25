<?php

namespace App\Models;

use App\Models\Payment;
use App\Traits\HasIndonesianDate;
use Carbon\Carbon;
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

    protected $casts = [
        'date_birth' => 'date',
        'date_join' => 'date',
    ];

    public const GENDERS = ['Male', 'Female'];

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected function getDateColumn(): string
    {
        return 'date_join';
    }

    // Search Scope
    public function scopeSearch($query, $search)
    {
        $query->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('npk', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        });
    }

    public function scopeActive($query)
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

    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'Male' => '♂ Laki-laki',
            'Female' => '♀ Perempuan',
            default => $this->gender,
        };
    }

    public function getGenderColorAttribute(): string
    {
        return match ($this->gender) {
            'Male' => 'blue',
            'Female' => 'red',
            default => 'zinc',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'Active' => 'Aktif',
            'Inactive' => 'Tidak Aktif',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Active' => 'green',
            'Inactive' => 'zinc',
            default => 'zinc',
        };
    }

    public function getAgeAttribute()
    {
        return $this->date_birth
            ? Carbon::parse($this->date_birth)->age
            : null;
    }
}
