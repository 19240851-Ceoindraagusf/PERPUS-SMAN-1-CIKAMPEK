<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        return view('admin.ebook-comments.index', compact('comments', 'approval'));
    }

    public function update(Request $request, EbookComment $comment): RedirectResponse
    {
        $comment->update(['is_approved' => $request->boolean('is_approved')]);

        return back()->with('success', 'Status komentar diperbarui.');
    }

    public function destroy(EbookComment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }
}
