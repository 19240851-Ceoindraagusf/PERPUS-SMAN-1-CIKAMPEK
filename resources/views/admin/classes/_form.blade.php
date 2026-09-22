@csrf
<div class="mb-3">
    <label class="form-label" for="name">Nama Kelas</label>
    <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $class->name ?? '') }}" required maxlength="100">
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label" for="description">Deskripsi</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $class->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="d-flex gap-2">
    <button class="btn btn-success" type="submit">Simpan</button>
    <a class="btn btn-outline-secondary" href="{{ route('admin.classes.index') }}">Batal</a>
</div>
