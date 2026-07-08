<?php

namespace App\Models;

use App\Traits\HasIndonesianDate;
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

    protected function getDateColumn(): string
    {
        return 'meeting_date';
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeSearch($query, $search)
    {
        $query->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('place', 'like', "%{$search}%")
                    ->orWhere('meeting_date', 'like', "%{$search}%");
            });
        });
    }
}
