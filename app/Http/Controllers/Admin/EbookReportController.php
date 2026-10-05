<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EbookReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EbookReportController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'open');
        $status = in_array($status, ['open', 'in_progress', 'resolved', 'all'], true) ? $status : 'open';
        $reports = EbookReport::with('ebook.subject.class')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.ebook-reports.index', compact('reports', 'status'));
    }

    public function update(Request $request, EbookReport $report): RedirectResponse
    {
        $validated = $request->validate(['status' => ['required', 'in:open,in_progress,resolved']]);
        $report->update($validated);

        return back()->with('success', 'Status laporan diperbarui.');
    }
}
