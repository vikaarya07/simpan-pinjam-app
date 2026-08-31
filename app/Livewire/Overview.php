<?php

namespace App\Livewire;

use App\Services\OverviewService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Overview extends Component
{
    public string $activitySort = 'date';

    public bool $showActivitiesModal = false;

    #[Computed]
    public function overview(): array
    {
        return app(OverviewService::class)
            ->get($this->activitySort);
    }

    public function render()
    {
        return view('livewire.overview');
    }
}
