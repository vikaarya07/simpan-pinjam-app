<?php

namespace App\Livewire\Saving;

use App\Models\Saving;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.saving.index', [
            'savings' => Saving::latest()
                ->paginate(10),
        ]);
    }
}
