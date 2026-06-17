<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'npk',
        'name',
        'slug',
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

    public static function generateNpk(): string
    {
        $lastMember = self::orderByDesc('npk')->first();

        if (! $lastMember) {
            return 'S001';
        }

        $lastNumber = (int) substr($lastMember->npk, 1);

        return 'S' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    public function getAgeAttribute()
    {
        return $this->date_birth
            ? Carbon::parse($this->date_birth)->age
            : null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
