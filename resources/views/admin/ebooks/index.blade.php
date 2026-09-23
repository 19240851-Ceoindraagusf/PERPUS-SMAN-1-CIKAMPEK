@extends('layouts.admin')

@section('title', 'Data E-Book')

@section('content')
<div class="d-flex justify-content-between align-items-center gap-3 mb-4">
    <h1 class="h3 mb-0">Data E-Book</h1>
    <a href="{{ route('admin.ebooks.create') }}" class="btn btn-success">Tambah E-Book</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle ebook-table">
            <thead><tr><th>Kelas</th><th>Mata Pelajaran</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($ebooks as $ebook)
                <tr>
                    <td>Kelas {{ $ebook->subject->class->name ?? '-' }}</td>
                    <td>{{ $ebook->subject->name ?? '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($ebook->author ?: '-', 55) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($ebook->publisher ?: '-', 80) }}</td>
                    <td>{{ $ebook->publication_year ?: '-' }}</td>
                    <td>{{ $ebook->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-success" href="{{ route('admin.ebooks.edit', $ebook) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.ebooks.destroy', $ebook) }}" onsubmit="return confirm('Hapus e-book ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-muted">Data e-book belum tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $ebooks->links('vendor.pagination.bootstrap-5-simple') }}</div>
</div>
@endsection
