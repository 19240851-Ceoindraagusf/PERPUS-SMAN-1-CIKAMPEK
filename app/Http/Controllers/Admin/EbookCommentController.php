<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\EbookComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EbookCommentController extends Controller
{
    public function index(Request $request): View
    {
        $approval = $request->query('approval', 'all');
        $approval = in_array($approval, ['pending', 'approved', 'all'], true) ? $approval : 'all';
        $comments = EbookComment::with('ebook.subject.class')
            ->when($approval === 'pending', fn ($query) => $query->where('is_approved', false))
            ->when($approval === 'approved', fn ($query) => $query->where('is_approved', true))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        EbookComment::whereNull('seen_by_admin_at')->update(['seen_by_admin_at' => now()]);

        return view('admin.ebook-comments.index', compact('comments', 'approval'));
    }

    public function update(Request $request, EbookComment $comment): RedirectResponse
    {
        $isApproved = $request->boolean('is_approved');
        $comment->update(['is_approved' => $isApproved]);
        $comment->load('ebook');
        $actionName = $isApproved ? 'Menyetujui' : 'Menolak';
        AuditLog::record('Approve', $actionName . ' komentar siswa "' . $comment->student_name . '" pada e-book "' . ($comment->ebook?->title ?? 'E-book') . '"', $comment);

        return back()->with('success', 'Status komentar diperbarui.');
    }

    public function destroy(EbookComment $comment): RedirectResponse
    {
        $comment->load('ebook');
        $studentName = $comment->student_name;
        $ebookTitle = $comment->ebook?->title ?? 'E-book';
        $comment->delete();
        AuditLog::record('Delete', 'Menghapus komentar siswa "' . $studentName . '" pada e-book "' . $ebookTitle . '"');

        return back()->with('success', 'Komentar dihapus.');
    }
}
