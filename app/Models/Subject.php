<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Subject extends Model
{
    use HasFactory;

    private const SCIENCE_BRANCH_SUBJECTS = [
        'biologi',
        'fisika',
        'kimia',
    ];

    private const SCIENCE_UMBRELLA_SUBJECTS = [
        'ipa',
        'ilmu pengetahuan alam',
    ];

    protected $fillable = [
        'class_id',
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function ebooks(): HasMany
    {
        return $this->hasMany(Ebook::class);
    }

    public function ebookSourceSubjectIds(): array
    {
        $subjectIds = [$this->id];

        if ($this->isScienceBranch()) {
            $subjectIds = array_merge($subjectIds, self::scienceSharedSubjectIdsForClass($this->class_id));
        }

        return array_values(array_unique($subjectIds));
    }

    public function sharedEbooks()
    {
        return Ebook::query()->whereIn('subject_id', $this->ebookSourceSubjectIds());
    }

    public function usesScienceUmbrellaEbooks(): bool
    {
        return $this->isScienceBranch() && count($this->ebookSourceSubjectIds()) > 1;
    }

    public function isScienceUmbrella(): bool
    {
        return in_array($this->normalizedName(), self::SCIENCE_UMBRELLA_SUBJECTS, true);
    }

    public function isScienceBranch(): bool
    {
        return in_array($this->normalizedName(), self::SCIENCE_BRANCH_SUBJECTS, true);
    }

    public static function scienceBranchNames(): array
    {
        return self::SCIENCE_BRANCH_SUBJECTS;
    }

    public static function scienceSharedSubjectIdsForClass(int $classId): array
    {
        return array_values(array_unique(array_merge(
            self::scienceBranchSubjectIdsForClass($classId),
            self::scienceUmbrellaSubjectIdsForClass($classId),
        )));
    }

    public static function scienceBranchSubjectIdsForClass(int $classId): array
    {
        return self::query()
            ->where('class_id', $classId)
            ->where(function ($query) {
                foreach (self::SCIENCE_BRANCH_SUBJECTS as $subjectName) {
                    $query->orWhereRaw('LOWER(name) = ?', [$subjectName]);
                }
            })
            ->pluck('id')
            ->all();
    }

    public static function scienceUmbrellaSubjectIdsForClass(int $classId): array
    {
        return self::query()
            ->where('class_id', $classId)
            ->where(function ($query) {
                foreach (self::SCIENCE_UMBRELLA_SUBJECTS as $subjectName) {
                    $query->orWhereRaw('LOWER(name) = ?', [$subjectName]);
                }
            })
            ->pluck('id')
            ->all();
    }

    private function normalizedName(): string
    {
        return Str::of($this->name)
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/i', ' ')
            ->squish()
            ->toString();
    }
}
