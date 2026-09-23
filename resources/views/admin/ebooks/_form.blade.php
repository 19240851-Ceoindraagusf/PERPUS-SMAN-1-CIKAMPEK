@csrf
@php
    $selectedClassId = old('class_id', $ebook->subject->class_id ?? '');
@endphp
<div class="mb-3">
    <label class="form-label" for="class_id">Kelas</label>
    <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id" required>
        <option value="">Pilih kelas</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" @selected((string) $selectedClassId === (string) $class->id)>Kelas {{ $class->name }}</option>
        @endforeach
    </select>
    @error('class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="subject_id">Mata Pelajaran</label>
    <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
        <option value="">Pilih mata pelajaran</option>
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" data-class-id="{{ $subject->class_id }}" @selected(old('subject_id', $ebook->subject_id ?? '') == $subject->id)>
                {{ $subject->name }} - Kelas {{ $subject->class->name ?? '-' }}
            </option>
        @endforeach
    </select>
    @error('subject_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label" for="author">Penulis</label>
        <input class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $ebook->author ?? '') }}">
        @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="publisher">Penerbit</label>
        <input class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" value="{{ old('publisher', $ebook->publisher ?? '') }}">
        @error('publisher')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="publication_year">Tahun Terbit</label>
        <input class="form-control @error('publication_year') is-invalid @enderror" id="publication_year" name="publication_year" type="number" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('publication_year', $ebook->publication_year ?? '') }}">
        @error('publication_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="description">Deskripsi</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $ebook->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="cover">Cover</label>
        <input class="form-control @error('cover') is-invalid @enderror" id="cover" name="cover" type="file" accept=".jpg,.jpeg,.png,.webp,image/*">
        @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @isset($ebook)
            @if($ebook->cover_path)
                <div class="form-text">Cover saat ini: {{ $ebook->cover_path }}</div>
            @endif
        @endisset
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="file">File PDF</label>
        <input class="form-control @error('file') is-invalid @enderror" id="file" name="file" type="file" accept="application/pdf,.pdf" @required(!isset($ebook))>
        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Maksimal 100 MB. Gunakan file PDF.</div>
        @isset($ebook)
            @if($ebook->file_path)
                <div class="form-text">File saat ini: {{ $ebook->file_path }}</div>
            @endif
        @endisset
    </div>
</div>
<div class="form-check form-switch mb-4">
    <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $ebook->is_active ?? true))>
    <label class="form-check-label" for="is_active">Aktif</label>
</div>
<div class="d-flex gap-2">
    <button class="btn btn-success" type="submit">Simpan</button>
    <a class="btn btn-outline-secondary" href="{{ route('admin.ebooks.index') }}">Batal</a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const classSelect = document.getElementById('class_id');
        const subjectSelect = document.getElementById('subject_id');
        const subjectOptions = Array.from(subjectSelect.options);

        function filterSubjects() {
            const selectedClass = classSelect.value;

            subjectOptions.forEach(function (option) {
                if (!option.value) {
                    option.hidden = false;
                    return;
                }

                option.hidden = option.dataset.classId !== selectedClass;
            });

            const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
            if (selectedOption && selectedOption.hidden) {
                subjectSelect.value = '';
            }
        }

        classSelect.addEventListener('change', filterSubjects);
        filterSubjects();
    });
</script>
