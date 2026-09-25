@csrf
<div class="alert alert-info">
    Pilih mata pelajaran tujuan. Sistem akan membaca halaman awal PDF untuk mengisi judul, penulis, penerbit, tahun terbit, dan deskripsi secara otomatis.
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="subject_id">Mata Pelajaran</label>
        <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
            <option value="">Pilih mata pelajaran</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" @selected((string) old('subject_id', $ebook->subject_id ?? '') === (string) $subject->id)>
                    Kelas {{ $subject->class->name }} - {{ $subject->name }}
                </option>
            @endforeach
        </select>
        @error('subject_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
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
