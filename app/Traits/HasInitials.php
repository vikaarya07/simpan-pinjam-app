<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasInitials
{
    public function initials(?string $name = null): string
    {
        $name ??= $this->getAttribute('name');

        if (blank($name)) {
            return '?';
        }

        return Str::of($name)
            ->trim()
            ->explode(' ')
            ->filter()
            ->map(fn(string $word) => Str::upper(Str::substr($word, 0, 1)))
            ->take(2)
            ->join('');
    }
}
