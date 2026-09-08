<?php

namespace App\Livewire;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $locale = 'id';

    public function mount(): void
    {
        $this->locale = app()->getLocale();
    }

    public function changeLocale(string $locale): void
    {
        if (! in_array($locale, ['id', 'en'], true)) {
            return;
        }

        session()->put('locale', $locale);

        app()->setLocale($locale);

        $this->locale = $locale;

        $this->redirect(
            url()->previous(),
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
