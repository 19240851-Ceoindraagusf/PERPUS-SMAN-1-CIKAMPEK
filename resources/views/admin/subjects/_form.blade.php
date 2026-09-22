@csrf
<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label" for="name">Nama Mata Pelajaran</label>
        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $subject->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="code">Kode</label>
        <input class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $subject->code ?? '') }}">
        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="class_id">Kelas</label>
    <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id" required>
        <option value="">Pilih kelas</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" @selected(old('class_id', $subject->class_id ?? '') == $class->id)>Kelas {{ $class->name }}</option>
        @endforeach
    </select>
    @error('class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="description">Deskripsi</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $subject->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="alert alert-info">
    Status mata pelajaran otomatis: aktif jika sudah memiliki e-book, dan nonaktif jika belum ada e-book.
</div>
<div class="d-flex gap-2">
    <button class="btn btn-success" type="submit">Simpan</button>
    <a class="btn btn-outline-secondary" href="{{ route('admin.subjects.index') }}">Batal</a>
</div>
