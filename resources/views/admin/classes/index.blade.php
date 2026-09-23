@extends('layouts.admin')

@section('title', 'Data Kelas')

@section('content')
<div class="d-flex justify-content-between align-items-center gap-3 mb-4">
    <h1 class="h3 mb-0">Data Kelas</h1>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-success">Tambah Kelas</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>Nama</th><th>Deskripsi</th><th>Mata Pelajaran</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($classes as $class)
                <tr>
                    <td>Kelas {{ $class->name }}</td>
                    <td>{{ $class->description ?: '-' }}</td>
                    <td>{{ $class->subjects_count }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-success" href="{{ route('admin.classes.edit', $class) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" onsubmit="return confirm('Hapus kelas ini? Data mata pelajaran dan e-book terkait juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-muted">Data kelas belum tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $classes->links('vendor.pagination.bootstrap-5-simple') }}</div>
</div>
@endsection
