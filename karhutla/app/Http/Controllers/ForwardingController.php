<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportForwarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForwardingController extends Controller
{
    // Daftar laporan yang siap diteruskan
    public function index()
    {
        $reports = Report::with(['address', 'reporter'])
            ->where('status', 'reviewed')
            ->latest()
            ->paginate(10);

        return view('coordinator.forwardings.index', compact('reports'));
    }

    // Form penerusan laporan
    public function create($id)
    {
        $report = Report::with(['address', 'reporter'])
            ->where('status', 'reviewed')
            ->findOrFail($id);

        return view('coordinator.forwardings.create', compact('report'));
    }

    // Menyimpan penerusan laporan
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'destination_name' => ['required', 'string', 'max:255'],
            'forwarded_at' => ['required', 'date'],
            'forwarding_note' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated, $id) {
            $report = Report::where('status', 'reviewed')
                ->lockForUpdate()
                ->findOrFail($id);

            ReportForwarding::create([
                'report_id' => $report->report_id,
                'coordinator_id' => Auth::id(),
                'destination_name' => $validated['destination_name'],
                'forwarded_at' => $validated['forwarded_at'],
                'forwarding_note' => $validated['forwarding_note'] ?? null,
            ]);

            $report->update([
                'status' => 'forwarded',
            ]);
        });

        return redirect()
            ->route('coordinator.forwardings.index')
            ->with('success', 'Laporan berhasil diteruskan ke instansi tujuan.');
    }
    
    public function recap(Request $request)
    {
        $allowedStatuses = [
            'submitted',
            'under_review',
            'reviewed',
            'forwarded',
            'closed',
        ];

        $status = $request->query('status');

        $query = Report::with(['address', 'reporter']);

        // Filter berdasarkan status
        if (in_array($status, $allowedStatuses)) {
            $query->where('status', $status);
        }

        $reports = $query->latest()->paginate(10)->withQueryString();

        // Tiga metrik rekapitulasi
        $totalReports = (clone $query)->count();

        $activeReports = (clone $query)
            ->whereIn('status', ['submitted', 'under_review'])
            ->count();

        $forwardedReports = (clone $query)
            ->whereIn('status', ['forwarded', 'closed'])
            ->count();

        return view('coordinator.recap.index', compact(
            'reports',
            'totalReports',
            'activeReports',
            'forwardedReports',
            'status'
        ));
    }
}
