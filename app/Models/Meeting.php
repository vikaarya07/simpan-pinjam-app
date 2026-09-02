<?php

namespace App\Models;

use App\Traits\HasIndonesianDate;
use Illuminate\Database\Eloquent\Builder;
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

    //  Date Helper
    protected function getDateColumn(): string
    {
        return 'meeting_date';
    }

    //  Search Scope
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, fn(Builder $query) => $query->where('place', 'like', "%{$search}%"));
    }
}
