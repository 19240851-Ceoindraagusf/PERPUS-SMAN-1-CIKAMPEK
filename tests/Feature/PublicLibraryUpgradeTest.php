<?php

namespace Tests\Feature;

use App\Models\AccessLog;
use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicLibraryUpgradeTest extends TestCase
{
    use RefreshDatabase;

    public function test_library_search_filters_are_visible_and_work(): void
    {
        $class = ClassModel::create([
            'name' => 'X',
            'description' => 'Kelas sepuluh',
            'is_active' => true,
        ]);

        $subject = Subject::create([
            'class_id' => $class->id,
            'name' => 'Biologi',
            'code' => 'BIO',
            'description' => 'Biologi dasar',
            'is_active' => true,
        ]);

        Ebook::create([
            'subject_id' => $subject->id,
            'title' => 'Biologi Dasar',
            'description' => 'Pengenalan biologi untuk siswa.',
            'author' => 'Budi',
            'publisher' => 'Sekolah',
            'publication_year' => 2024,
            'file_path' => 'ebooks/biology.pdf',
            'is_active' => true,
        ]);

        $response = $this->get(route('library', [
            'q' => 'Biologi',
            'class' => 'X',
            'subject' => 'Biologi',
        ]));

        $response->assertOk()
            ->assertSee('Biologi Dasar')
            ->assertSee('Kelas X');
    }

    public function test_catalog_can_filter_by_year_and_author_and_reader_is_available(): void
    {
        $class = ClassModel::create(['name' => 'X', 'is_active' => true]);
        $subject = Subject::create(['class_id' => $class->id, 'name' => 'Kimia', 'is_active' => true]);
        $matchingEbook = Ebook::create([
            'subject_id' => $subject->id,
            'title' => 'Kimia 2025',
            'author' => 'Ani',
            'publication_year' => 2025,
            'file_path' => 'ebooks/kimia.pdf',
            'is_active' => true,
        ]);
        Ebook::create([
            'subject_id' => $subject->id,
            'title' => 'Kimia Lama',
            'author' => 'Budi',
            'publication_year' => 2023,
            'is_active' => true,
        ]);

        $this->get(route('library', ['year' => 2025, 'author' => 'Ani', 'sort' => 'title']))
            ->assertOk()
            ->assertSee('Kimia 2025')
            ->assertDontSee('Kimia Lama')
            ->assertSee('Tahun terbit')
            ->assertSee('Paling sering dibaca');

        $this->get(route('favorites'))->assertOk()->assertSee('Favorit & Terakhir Dibuka', false);
        Storage::fake('public');
        Storage::disk('public')->put('ebooks/kimia.pdf', 'PDF placeholder');
        $this->get(route('ebooks.reader', $matchingEbook))
            ->assertOk()
            ->assertSee('Pembaca PDF');
    }

    public function test_search_suggestions_and_sitemap_expose_public_collection(): void
    {
        $class = ClassModel::create(['name' => 'X', 'is_active' => true]);
        $subject = Subject::create(['class_id' => $class->id, 'name' => 'Biologi', 'is_active' => true]);
        $ebook = Ebook::create(['subject_id' => $subject->id, 'title' => 'Biologi Dasar', 'author' => 'Ibu Sari', 'is_active' => true]);

        $this->get(route('search.suggestions', ['q' => 'Biol']))
            ->assertOk()
            ->assertJsonFragment(['title' => 'Biologi Dasar']);

        $this->get(route('search.suggestions', ['q' => 'Biolgi']))
            ->assertOk()
            ->assertJsonPath('correction.label', 'Mungkin maksud Anda: Biologi');

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('ebooks.show', $ebook), false);
    }

    public function test_admin_dashboard_shows_analytics_sections(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $class = ClassModel::create([
            'name' => 'XI',
            'description' => 'Kelas sebelas',
            'is_active' => true,
        ]);

        $subject = Subject::create([
            'class_id' => $class->id,
            'name' => 'Matematika',
            'code' => 'MAT',
            'description' => 'Pelajaran matematika',
            'is_active' => true,
        ]);

        $ebook = Ebook::create([
            'subject_id' => $subject->id,
            'title' => 'Matematika Dasar',
            'description' => 'Buku latihan matematik',
            'author' => 'Sari',
            'publisher' => 'Sekolah',
            'publication_year' => 2024,
            'file_path' => 'ebooks/math.pdf',
            'is_active' => true,
        ]);

        AccessLog::create([
            'ebook_id' => $ebook->id,
            'accessed_at' => now(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'phpunit',
        ]);

        $response = $this->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertSee('E-Book Paling Banyak Diakses')
            ->assertSee('Kelas dengan Materi Terbanyak')
            ->assertSee('Mapel Paling Banyak Diakses')
            ->assertSee('Audit kualitas koleksi')
            ->assertSee('Prioritas perbaikan koleksi');
    }

    public function test_inactive_ebook_cannot_be_viewed_or_downloaded(): void
    {
        $class = ClassModel::create(['name' => 'X', 'is_active' => true]);
        $subject = Subject::create(['class_id' => $class->id, 'name' => 'Matematika', 'is_active' => true]);
        $ebook = Ebook::create([
            'subject_id' => $subject->id,
            'title' => 'Buku Nonaktif',
            'file_path' => 'ebooks/inactive.pdf',
            'is_active' => false,
        ]);

        $this->get(route('ebooks.show', $ebook))->assertNotFound();
        $this->get(route('ebooks.download', $ebook))->assertNotFound();
        $this->assertDatabaseCount('access_logs', 0);
    }

    public function test_access_logs_store_anonymized_ip_addresses(): void
    {
        $class = ClassModel::create(['name' => 'X', 'is_active' => true]);
        $subject = Subject::create(['class_id' => $class->id, 'name' => 'Matematika', 'is_active' => true]);
        $ebook = Ebook::create([
            'subject_id' => $subject->id,
            'title' => 'Buku Aktif',
            'file_path' => 'ebooks/active.pdf',
            'is_active' => true,
        ]);

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.27'])
            ->get(route('ebooks.show', $ebook))
            ->assertOk();

        $this->assertDatabaseHas('access_logs', [
            'ebook_id' => $ebook->id,
            'ip_address' => '203.0.113.0',
        ]);
    }

    public function test_access_log_pruning_removes_only_expired_logs(): void
    {
        $class = ClassModel::create(['name' => 'X', 'is_active' => true]);
        $subject = Subject::create(['class_id' => $class->id, 'name' => 'Matematika', 'is_active' => true]);
        $ebook = Ebook::create(['subject_id' => $subject->id, 'title' => 'Buku Aktif', 'is_active' => true]);
        $expiredLog = AccessLog::create(['ebook_id' => $ebook->id, 'accessed_at' => now()->subDays(91)]);
        $recentLog = AccessLog::create(['ebook_id' => $ebook->id, 'accessed_at' => now()->subDays(89)]);

        $this->artisan('access-logs:prune')->assertSuccessful();

        $this->assertDatabaseMissing('access_logs', ['id' => $expiredLog->id]);
        $this->assertDatabaseHas('access_logs', ['id' => $recentLog->id]);
    }
}
