<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasIndonesianDate
{
    protected static function bootHasIndonesianDate()
    {
        Carbon::setLocale('id');
    }

    protected function getDateColumn(): string
    {
        return property_exists($this, 'indonesianDateColumn')
            ? $this->indonesianDateColumn
            : 'created_at';
    }

    public function getWaktuLengkapAttribute()
    {
        $column = $this->getDateColumn();

        return $this->{$column}
            ? $this->{$column}->translatedFormat('l, d F Y | H:i')
            : null;
    }

    public function getWaktuAttribute()
    {
        $column = $this->getDateColumn();

        return $this->{$column}
            ? $this->{$column}->translatedFormat('l, d F Y')
            : null;
    }

    public function getTanggalJamAttribute()
    {
        $column = $this->getDateColumn();

        return $this->{$column}
            ? $this->{$column}->translatedFormat('d F Y | H:i')
            : null;
    }

    public function getTanggalAttribute()
    {
        $column = $this->getDateColumn();

        return $this->{$column}
            ? $this->{$column}->translatedFormat('d F Y')
            : null;
    }

    public function getJamAttribute()
    {
        $column = $this->getDateColumn();

        return $this->{$column}
            ? $this->{$column}->translatedFormat('H:i')
            : null;
    }
}
