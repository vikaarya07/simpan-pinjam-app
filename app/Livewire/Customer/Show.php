<?php

namespace App\Livewire\Customer;

use App\Models\Member;
use Livewire\Component;

class Show extends Component
{
    public Member $customer;

    public function mount(Member $customer): void
    {
        abort_unless(
            $customer->loans()
                ->isCustomer()
                ->exists(),
            404
        );

        $this->customer = $customer->load([
            'loans' => fn($query) => $query
                ->isCustomer()
                ->with([
                    'payments' => fn($query) => $query
                        ->orderBy('payment_count'),
                ])
                ->latest(),
        ]);
    }
    
    public function render()
    {
        return view('livewire.customer.show');
    }
}
