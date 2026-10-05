<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EbookCommentReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EbookCommentReportController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'open');
        $status = in_array($status, ['open', 'resolved', 'all'], true) ? $status : 'open';
        $reports = EbookCommentReport::with('comment.ebook.subject.class')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.comment-reports.index', compact('reports', 'status'));
    }

    public function update(Request $request, EbookCommentReport $report): RedirectResponse
    {
        $validated = $request->validate(['status' => ['required', 'in:open,resolved']]);
        $report->update($validated);

        return back()->with('success', 'Status laporan komentar diperbarui.');
    }
}
