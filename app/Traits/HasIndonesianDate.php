<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasIndonesianDate
{
    protected static function bootHasIndonesianDate()
    {
        Carbon::setLocale('id');
    }

    public function getWaktuAttribute()
    {
        return $this->created_at
            ? $this->created_at->translatedFormat('d F Y H:i')
            : null;
    }

    public function getTanggalAttribute()
    {
        return $this->created_at
            ? $this->created_at->translatedFormat('d F Y')
            : null;
    }
}
