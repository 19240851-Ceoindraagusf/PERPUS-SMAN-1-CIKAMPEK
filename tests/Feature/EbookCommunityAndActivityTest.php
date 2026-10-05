<?php

namespace Tests\Feature;

use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\EbookComment;
use App\Models\EbookCommentReport;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EbookCommunityAndActivityTest extends TestCase
{
    use RefreshDatabase;

    private function ebook(): Ebook
    {
        $class = ClassModel::create(['name' => 'X', 'is_active' => true]);
        $subject = Subject::create(['class_id' => $class->id, 'name' => 'Biologi', 'is_active' => true]);

        return Ebook::create([
            'subject_id' => $subject->id,
            'title' => 'Biologi Dasar',
            'file_path' => 'ebooks/biologi.pdf',
            'is_active' => true,
        ]);
    }

    public function test_activity_is_recorded_once_per_ebook_action_per_session_per_day(): void
    {
        Storage::fake('public');
        $ebook = $this->ebook();
        Storage::disk('public')->put($ebook->file_path, 'PDF placeholder');

        $this->get(route('ebooks.show', $ebook))->assertOk();
        $this->get(route('ebooks.show', $ebook))->assertOk();
        $this->get(route('ebooks.reader', $ebook))->assertOk();
        $this->get(route('ebooks.reader', $ebook))->assertOk();
        $this->get(route('ebooks.download', $ebook))->assertOk();

        $this->assertDatabaseCount('access_logs', 3);
        $this->assertDatabaseHas('access_logs', ['ebook_id' => $ebook->id, 'action' => 'view']);
        $this->assertDatabaseHas('access_logs', ['ebook_id' => $ebook->id, 'action' => 'read']);
        $this->assertDatabaseHas('access_logs', ['ebook_id' => $ebook->id, 'action' => 'download']);
    }

    public function test_students_can_submit_reports_and_comments_that_are_visible_immediately(): void
    {
        $ebook = $this->ebook();

        $this->post(route('ebooks.reports.store', $ebook), [
            'reporter_name' => 'Anisa',
            'category' => 'pdf_broken',
            'message' => 'PDF berhenti dimuat di halaman pertama.',
        ])->assertSessionHas('success');
        $this->assertDatabaseHas('ebook_reports', ['ebook_id' => $ebook->id, 'reporter_name' => 'Anisa', 'status' => 'open']);

        $this->post(route('ebooks.comments.store', $ebook), [
            'display_name' => 'Anisa',
            'message' => 'Materi klasifikasi makhluk hidup sangat membantu untuk belajar mandiri.',
        ])->assertSessionHas('success');
        $comment = EbookComment::firstOrFail();
        $this->assertTrue($comment->is_approved);

        $this->get(route('ebooks.show', $ebook))
            ->assertOk()
            ->assertSee('Materi klasifikasi makhluk hidup sangat membantu untuk belajar mandiri.');
        $this->get(route('comments.index'))
            ->assertOk()
            ->assertSee('Anisa')
            ->assertSee('Materi klasifikasi makhluk hidup sangat membantu untuk belajar mandiri.');

        $this->post(route('comments.reports.store', $comment), ['reason' => 'irrelevant'])
            ->assertSessionHas('success');
        $this->assertDatabaseHas('ebook_comment_reports', ['ebook_comment_id' => $comment->id, 'reason' => 'irrelevant', 'status' => 'open']);

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.ebook-comments.index'))->assertOk()->assertSee('Anisa');
        $this->get(route('admin.comment-reports.index'))->assertOk()->assertSee('Tidak relevan');
        $this->patch(route('admin.ebook-comments.update', $comment), ['is_approved' => false])->assertSessionHas('success');

        $this->get(route('ebooks.show', $ebook))
            ->assertOk()
            ->assertDontSee('Materi klasifikasi makhluk hidup sangat membantu untuk belajar mandiri.');
    }
}
