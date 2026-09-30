<?php

namespace App\Services;

use App\Models\Ebook;
use Illuminate\Support\Facades\Storage;

class EbookFileCleanup
{
    public function delete(Ebook $ebook): void
    {
        $filePath = $ebook->file_path;
        $coverPath = $ebook->cover_path;

        $ebook->delete();

        $this->deleteIfUnused($filePath, 'file_path');
        $this->deleteIfUnused($coverPath, 'cover_path');
    }

    private function deleteIfUnused(?string $path, string $column): void
    {
        if (! $path || Ebook::where($column, $path)->exists()) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
