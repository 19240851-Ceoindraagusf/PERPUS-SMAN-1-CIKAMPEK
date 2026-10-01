<?php

namespace Tests\Feature;

use App\Models\ClassModel;
use App\Models\Ebook;
use App\Models\Subject;
use App\Models\User;
use App\Services\EbookMetadataExtractor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminFilterPersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_subject_edit_page_keeps_class_filter_on_cancel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $class = ClassModel::create([
            'name' => 'X',
            'description' => 'Kelas sepuluh',
            'is_active' => true,
        ]);

        $subject = Subject::create([
            'class_id' => $class->id,
            'name' => 'Matematika',
            'code' => 'MAT',
            'description' => 'Pelajaran matematika',
            'is_active' => true,
        ]);

        $response = $this->get(route('admin.subjects.edit', ['subject' => $subject, 'class_id' => $class->id]));

        $response->assertOk()
            ->assertSee(route('admin.subjects.index', ['class_id' => $class->id]), false);
    }

    public function test_ebook_edit_page_keeps_filter_values_on_cancel_and_submit(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $class = ClassModel::create([
            'name' => 'XI',
            'description' => 'Kelas sebelas',
            'is_active' => true,
        ]);

        $subject = Subject::create([
            'class_id' => $class->id,
            'name' => 'Biologi',
            'code' => 'BIO',
            'description' => 'Pelajaran biologi',
            'is_active' => true,
        ]);

        $ebook = Ebook::create([
            'subject_id' => $subject->id,
            'title' => 'Biologi Dasar',
            'description' => 'Deskripsi lama',
            'author' => 'Penulis Lama',
            'publisher' => 'Penerbit Lama',
            'publication_year' => 2024,
            'file_path' => 'ebooks/old.pdf',
            'is_active' => true,
        ]);

        $response = $this->get(route('admin.ebooks.edit', ['ebook' => $ebook, 'class_id' => $class->id, 'subject_id' => $subject->id]));

        $response->assertOk()
            ->assertSee('admin/ebooks?class_id=' . $class->id . '&amp;subject_id=' . $subject->id, false)
            ->assertSee('name="return_class_id"', false)
            ->assertSee('name="return_subject_id"', false);
    }

    public function test_manual_ebook_metadata_overrides_pdf_detection_and_empty_fields_use_detection(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $class = ClassModel::create([
            'name' => 'X',
            'description' => 'Kelas sepuluh',
            'is_active' => true,
        ]);
        $subject = Subject::create([
            'class_id' => $class->id,
            'name' => 'Biologi',
            'is_active' => true,
        ]);

        Storage::fake('public');
        $metadata = [
            'title' => 'Biologi Dasar',
            'author' => 'Penulis PDF',
            'publisher' => 'Penerbit PDF',
            'publication_year' => 2022,
            'description' => 'Deskripsi dari PDF',
        ];

        $extractor = \Mockery::mock(EbookMetadataExtractor::class);
        $extractor->shouldReceive('extract')->twice()->andReturn($metadata, $metadata);
        $extractor->shouldReceive('titleForSelectedSubject')->twice()->andReturn('Biologi Dasar');
        $extractor->shouldReceive('buildSubjectDescription')->twice()->andReturn('Deskripsi mapel');
        $this->app->instance(EbookMetadataExtractor::class, $extractor);

        $this->post(route('admin.ebooks.store'), [
            'subject_id' => $subject->id,
            'author' => 'Penulis Manual',
            'publisher' => 'Penerbit Manual',
            'publication_year' => '2025',
            'file' => UploadedFile::fake()->create('manual.pdf', 10, 'application/pdf'),
        ])->assertRedirect(route('admin.ebooks.index'));

        $this->assertDatabaseHas('ebooks', [
            'author' => 'Penulis Manual',
            'publisher' => 'Penerbit Manual',
            'publication_year' => 2025,
        ]);

        $this->post(route('admin.ebooks.store'), [
            'subject_id' => $subject->id,
            'author' => '',
            'publisher' => '',
            'publication_year' => '',
            'file' => UploadedFile::fake()->create('automatic.pdf', 10, 'application/pdf'),
        ])->assertRedirect(route('admin.ebooks.index'));

        $this->assertDatabaseHas('ebooks', [
            'author' => 'Penulis PDF',
            'publisher' => 'Penerbit PDF',
            'publication_year' => 2022,
        ]);
    }

    public function test_same_subject_name_in_different_classes_is_not_mixed(): void
    {
        $classX = ClassModel::create([
            'name' => 'X',
            'description' => 'Kelas sepuluh',
            'is_active' => true,
        ]);

        $classXi = ClassModel::create([
            'name' => 'XI',
            'description' => 'Kelas sebelas',
            'is_active' => true,
        ]);

        $subjectX = Subject::create([
            'class_id' => $classX->id,
            'name' => 'Kimia',
            'description' => 'Kimia X',
            'is_active' => true,
        ]);

        $subjectXi = Subject::create([
            'class_id' => $classXi->id,
            'name' => 'Kimia',
            'description' => 'Kimia XI',
            'is_active' => true,
        ]);

        $this->assertSame($subjectX->id, Subject::findByClassAndName($classX->id, 'Kimia')->id);
        $this->assertSame($subjectXi->id, Subject::findByClassAndName($classXi->id, 'Kimia')->id);
        $this->assertNotSame($subjectX->id, Subject::findByClassAndName($classXi->id, 'Kimia')->id);
    }
}
