<?php

namespace App\Livewire;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $locale;

    public function mount(): void
    {
        $this->locale = session('locale', config('app.locale'));
    }

    public function changeLocale(string $locale): void
    {
        if (! in_array($locale, ['id', 'en'], true)) {
            return;
        }

        session()->put('locale', $locale);

        $this->locale = $locale;

        $this->redirect(
            url()->previous(),
            navigate: false
        );
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
