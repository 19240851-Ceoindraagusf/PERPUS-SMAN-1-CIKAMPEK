<?php

namespace Tests\Feature;

use App\Models\AccessLog;
use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->assertSee('Mapel Paling Banyak Diakses');
    }
}
