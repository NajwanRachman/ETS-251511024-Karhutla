<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Report;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with('address')
            ->where('reporter_id', Auth::id());

        // Pencarian ID laporan atau wilayah
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->where('report_id', $search);
                }

                $q->orWhereHas('address', function ($addressQuery) use ($search) {
                    $addressQuery->where('detail_address', 'like', "%{$search}%")
                        ->orWhere('city_regency', 'like', "%{$search}%")
                        ->orWhere('province', 'like', "%{$search}%");
                });
            });
        }

        // Filter status
        if (in_array($request->status, [
            'submitted', 'under_review', 'reviewed', 'forwarded', 'closed'
        ])) {
            $query->where('status', $request->status);
        }

        // Filter tingkat kondisi
        if (in_array($request->condition, ['low', 'medium', 'high'])) {
            $query->where('condition_level', $request->condition);
        }

        $reports = $query->latest()
            ->paginate(5)
            ->withQueryString();

        return view('reporter.index', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::with([
            'address',
            'reviews.volunteer'
        ])
            ->where('reporter_id', Auth::id())
            ->findOrFail($id);

        return view('reporter.show', compact('report'));
    }

    public function create()
    {
        $addresses = Address::all();

        return view('reporter.create', compact('addresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_id' => ['required', 'exists:addresses,address_id'],
            'report_description' => ['required', 'string'],
            'incident_time' => ['required', 'date'],
            'condition_level' => ['required', 'in:low,medium,high'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'evidence_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $evidencePath = null;

        if ($request->hasFile('evidence_file')) {
            $evidencePath = $request->file('evidence_file')
                ->store('evidence', 'public');
        }

        Report::create([
            'reporter_id' => Auth::id(),
            'address_id' => $validated['address_id'],
            'report_description' => $validated['report_description'],
            'incident_time' => $validated['incident_time'],
            'condition_level' => $validated['condition_level'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'evidence_file' => $evidencePath,
            'status' => 'submitted',
        ]);

        return redirect()
            ->route('reporter.dashboard')
            ->with('success', 'Laporan berhasil dikirim!');
    }

     // Daftar laporan untuk Volunteer
    public function volunteerIndex()
    {
        $reports = Report::with(['address', 'reporter'])
            ->latest()
            ->paginate(10);

        return view('volunteer.reports.index', compact('reports'));
    }
    // Detail laporan untuk Volunteer
    public function volunteerShow($id)
    {
        $report = Report::with([
            'address',
            'reporter',
            'reviews.volunteer'
        ])->findOrFail($id);

        return view('volunteer.reports.show', compact('report'));
    }
    // Menyimpan hasil pemeriksaan Volunteer
    public function review(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        if (!in_array($report->status, ['submitted', 'under_review'])) {
            return back()->with('error', 'Laporan ini tidak dapat diperiksa lagi.');
        }

        $validated = $request->validate([
            'review_data' => ['required', 'in:layak,tidak_layak'],
            'review_note' => ['required', 'string', 'max:1000'],
            'follow_up_required' => ['required', 'boolean'],
        ]);

        $report->reviews()->create([
            'volunteer_id' => Auth::id(),
            'review_data' => $validated['review_data'],
            'review_note' => $validated['review_note'],
            'follow_up_required' => $validated['follow_up_required'],
        ]);

        $report->update([
            'status' => 'reviewed',
        ]);

        return redirect()
            ->route('volunteer.reports.show', $id)
            ->with('success', 'Hasil pemeriksaan berhasil disimpan.');
    }
    // Mengambil laporan aktif di wilayah yang dipilih
    public function areaReports($addressId)
    {
        $address = Address::findOrFail($addressId);

        $reports = Report::with('address')
            ->whereHas('address', function ($query) use ($address) {
                $query->where('city_regency', $address->city_regency)
                    ->where('province', $address->province);
            })
            ->where('status', '!=', 'closed')
            ->latest()
            ->get()
            ->map(function ($report) {
                return [
                    'report_id' => $report->report_id,
                    'location' => $report->address->detail_address . ', ' .
                        $report->address->city_regency,
                    'condition' => $report->condition_level,
                    'status' => $report->status,
                    'incident_time' => $report->incident_time->format('d/m/Y H:i'),
                ];
            });

        return response()->json($reports);
    }
}
