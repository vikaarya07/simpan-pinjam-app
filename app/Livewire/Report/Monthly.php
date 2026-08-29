<?php

namespace App\Livewire\Report;

use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Monthly extends Component
{
    public int $year;
    public int $month;

    public function mount(): void
    {
        $this->year = now()->year;
        $this->month = now()->month;
    }

    public function confirmDownloadPdf(): void
    {
        $monthName = Carbon::create()
            ->month($this->month)
            ->translatedFormat('F');

        $this->dispatch(
            'confirm-download-pdf',
            action: 'download-pdf',
            text: "Laporan Simpan Pinjam Bulan {$monthName} {$this->year}",
        );
    }

    #[On('download-pdf')]
    public function downloadPdf()
    {
        $report = app(ReportService::class)
            ->monthly($this->year, $this->month);

        $monthName = Carbon::create()
            ->month($this->month)
            ->translatedFormat('F');

        $filename = "Laporan Simpan Pinjam Bulan {$monthName} {$this->year} SATYA MUDA GETAS.pdf";

        return response()->streamDownload(
            function () use ($report) {
                echo Pdf::loadView(
                    'pdf.monthly-report',
                    compact('report')
                )->output();
            },
            $filename
        );
    }

    public function render()
    {
        $report = app(ReportService::class)
            ->monthly($this->year, $this->month);

        return view('livewire.report.monthly', [
            'report' => $report,
        ]);
    }
}
