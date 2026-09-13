<?php

namespace App\Livewire\Report;

use App\Enums\NotificationType;
use App\Models\CustomerNotification;
use App\Models\Member;
use App\Services\NotificationService;
use App\Services\ReportService;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Customer extends Component
{
    use WithPagination;

    #[Url] public int|string $customerId = '';

    #[Url] public int|string $loanId = '';

    #[Url] public string $tab = 'summary';

    #[Url] public string $search = '';

    #[Url] public string $type = '';

    public bool $showNotificationModal = false;

    public ?CustomerNotification $selectedNotification = null;

    public ?string $selectedNotificationMessage = null;

    // Customers 
    #[Computed] public function customers()
    {
        return Member::query()
            ->whereHas(
                'loans',
                fn($query) => $query->isCustomer()
            )
            ->orderBy('name')
            ->get();
    }

    // Current Customer 
    #[Computed] public function customer(): ?Member
    {
        if (! $this->customerId) {
            return null;
        }
        return Member::query()
            ->find($this->customerId);
    }

    // Customer Loans 
    #[Computed] public function loans()
    {
        if (! $this->customer) {
            return collect();
        }
        return $this->customer
            ->loans()
            ->isCustomer()
            ->latest('loan_date')
            ->get();
    }

    // Selected Loan 
    #[Computed] public function loan()
    {
        if (! $this->customer || ! $this->loanId) {
            return null;
        }
        return $this->customer
            ->loans()
            ->isCustomer()
            ->find($this->loanId);
    }

    // Customer Report 
    #[Computed] public function report()
    {
        if (! $this->customer) {
            return null;
        }
        return app(ReportService::class)
            ->customer($this->customer);
    }

    // Notifications 
    #[Computed] public function notifications(): LengthAwarePaginator
    {
        if (! $this->customer || ! $this->loanId) {
            return new LengthAwarePaginator(
                collect(),
                0,
                10,
                $this->getPage(),
                ['path' => request()->url(),]
            );
        }

        return CustomerNotification::query()
            ->where('member_id', $this->customer->id)
            ->where('loan_id', $this->loanId)
            ->when(
                filled($this->search),
                function ($query) {
                    $search = trim($this->search);

                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('title', 'like', "%{$search}%")
                            ->orWhere('message', 'like', "%{$search}%");
                    });
                }
            )->when(
                filled($this->type),
                fn($query) => $query
                    ->where('type', $this->type)
            )
            ->latest()
            ->paginate(10);
    }

    // Notification Count 
    #[Computed] public function notificationCount(): int
    {
        if (! $this->customer || ! $this->loanId) {
            return 0;
        }
        return CustomerNotification::query()
            ->where('member_id', $this->customer->id)
            ->where('loan_id', $this->loanId)
            ->count();
    }

    // Unread Notification Count 
    #[Computed] public function unreadNotificationCount(): int
    {
        if (! $this->customer || ! $this->loanId) {
            return 0;
        }

        return CustomerNotification::query()
            ->where('member_id', $this->customer->id)
            ->where('loan_id', $this->loanId)
            ->whereNull('read_at')
            ->count();
    }

    // Notification Types 
    #[Computed] public function notificationTypes(): array
    {
        return NotificationType::cases();
    }

    // Customer Changed 
    public function updatedCustomerId(): void
    {
        $this->loanId = $this->loans->first()?->id ?? '';

        $this->resetPage();

        $this->tab = 'summary';
        $this->search = '';
        $this->type = '';

        $this->closeNotification();
    }

    // Loan Changed 
    public function updatedLoanId(): void
    {
        $this->resetPage();
        $this->search = '';
        $this->type = '';
        $this->closeNotification();
    }

    // Select Loan 
    public function selectLoan(int $loanId): void
    {
        $loan = $this->customer
            ->loans()
            ->isCustomer()
            ->whereKey($loanId)
            ->firstOrFail();

        $this->loanId = $loan->id;
        $this->tab = 'notification';

        $this->resetPage();

        $this->search = '';
        $this->type = '';

        $this->closeNotification();
    }

    // Notification Filters 
    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    public function updatedType(): void
    {
        $this->resetPage();
    }

    // Tab 
    public function selectTab(string $tab): void
    {
        if (! in_array($tab, [
            'summary',
            'loans',
            'notification',
        ], true)) {
            return;
        }

        $this->tab = $tab;

        if ($tab !== 'notification') {
            $this->resetPage();
        }
    }

    // Open Notification 
    public function openNotification(int $id): void
    {
        if (! $this->customer || ! $this->loanId) {
            return;
        }

        $notification = CustomerNotification::query()
            ->where('member_id', $this->customer->id)
            ->where('loan_id', $this->loanId)
            ->with([
                'loan.member',
                'loan.payments',
                'payment.loan.member',
                'payment.meeting',
                'meeting',
            ])
            ->findOrFail($id);

        $this->selectedNotificationMessage = app(NotificationService::class)
            ->previewMessage($notification);

        if (! $notification->read_at) {
            $notification->update([
                'read_at' => now(),
            ]);
        }

        $this->selectedNotification = $notification;
        $this->showNotificationModal = true;
    }

    // Close Notification 
    public function closeNotification(): void
    {
        $this->showNotificationModal = false;
        $this->selectedNotification = null;
        $this->selectedNotificationMessage = null;
    }

    // Send Notification 
    public function sendNotification(int $id): void
    {
        if (! $this->customer || ! $this->loanId) {
            return;
        }
        $notification = CustomerNotification::query()
            ->where('member_id', $this->customer->id)
            ->where('loan_id', $this->loanId)
            ->findOrFail($id);

        if ($notification->sent_at) {
            $this->dispatch(
                'swal',
                icon: 'info',
                title: 'Sudah Terkirim',
                text: 'Notifikasi ini sudah pernah dikirim.',
            );
            return;
        }

        // Sementara | WhatsApp gateway belum diaktifkan. */
        $this->dispatch(
            'swal',
            icon: 'info',
            title: 'Belum tersedia',
            text: 'Pengiriman WhatsApp akan diaktifkan pada tahap berikutnya.',
        );
    }

    // Download PDF 
    public function downloadPdf()
    {
        if (! $this->customer) {
            $this->dispatch(
                'swal',
                icon: 'warning',
                title: 'Pilih Nasabah',
                text: 'Silakan pilih nasabah terlebih dahulu.',
            );
            return;
        }
        $this->dispatch(
            'swal',
            icon: 'info',
            title: 'Belum tersedia',
            text: 'Export PDF laporan nasabah akan dibuat pada tahap berikutnya.',
        );
    }

    // Send Report WhatsApp 
    public function sendWhatsApp(): void
    {
        if (! $this->customer) {
            $this->dispatch(
                'swal',
                icon: 'warning',
                title: 'Pilih Nasabah',
                text: 'Silakan pilih nasabah terlebih dahulu.',
            );
            return;
        }
        $this->dispatch(
            'swal',
            icon: 'info',
            title: 'Belum tersedia',
            text: 'Pengiriman laporan melalui WhatsApp akan dibuat pada tahap berikutnya.',
        );
    }

    // Render 
    public function render()
    {
        return view('livewire.report.customer', [
            'report' => $this->report,
            'customers' => $this->customers,
            'loans' => $this->loans,
            'loan' => $this->loan,
            'notifications' => $this->notifications,
            'notificationTypes' => $this->notificationTypes,
        ]);
    }
}
