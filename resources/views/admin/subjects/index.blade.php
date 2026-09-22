@extends('layouts.admin')

@section('title', 'Data Mata Pelajaran')

@section('content')
<div class="d-flex justify-content-between align-items-center gap-3 mb-4">
    <h1 class="h3 mb-0">Data Mata Pelajaran</h1>
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-success">Tambah Mata Pelajaran</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>Nama</th><th>Kelas</th><th>Kode</th><th>E-Book</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->class->name ?? '-' }}</td>
                    <td>{{ $subject->code ?: '-' }}</td>
                    <td>{{ $subject->ebooks_count }}</td>
                    <td>
                        <span class="badge {{ $subject->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                            {{ $subject->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-success" href="{{ route('admin.subjects.edit', $subject) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.subjects.destroy', $subject) }}" onsubmit="return confirm('Hapus mata pelajaran ini? E-book terkait juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted">Data mata pelajaran belum tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $subjects->links() }}</div>
</div>
@endsection
