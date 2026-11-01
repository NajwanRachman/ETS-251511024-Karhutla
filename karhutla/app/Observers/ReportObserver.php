<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\ReportStatusLog;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    public function updated(Report $report): void
    {
        // Cek apakah status laporan berubah
        if ($report->wasChanged('status')) {
            ReportStatusLog::create([
                'report_id' => $report->report_id,
                'changed_by' => Auth::id(),
                'old_status' => $report->getOriginal('status'),
                'new_status' => $report->status,
            ]);
        }
    }
}
