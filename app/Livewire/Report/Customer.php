<?php

namespace App\Livewire\Report;

use App\Models\Member;
use App\Services\ReportService;
use Livewire\Component;

class Customer extends Component
{
    public int|string $customerId = '';

    public function render()
    {
        $report = null;

        if ($this->customerId) {
            $customer = Member::findOrFail($this->customerId);

            $report = app(ReportService::class)
                ->customer($customer);
        }

        return view('livewire.report.customer', [
            'report' => $report,
            'customers' => Member::query()
                ->whereHas('loans')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
