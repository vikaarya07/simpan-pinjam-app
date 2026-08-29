<?php

namespace App\Livewire\Customer\Notification;

use App\Enums\NotificationType;
use App\Models\CustomerNotification;
use App\Models\Member;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Member $customer;

    #[Url]
    public string $search = '';

    #[Url]
    public string $type = '';

    public function mount(Member $customer): void
    {
        $this->customer = $customer;
    }

    #[Computed]
    public function notifications()
    {
        return CustomerNotification::query()
            ->with([
                'loan',
                'payment',
                'meeting',
            ])
            ->where('member_id', $this->customer->id)
            ->when($this->search, function ($query) {
                $query->where('message', 'like', "%{$this->search}%");
            })
            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->latest('id')
            ->paginate(10);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedType(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.customer.notification.index', [
            'types' => NotificationType::cases(),
        ]);
    }
}
