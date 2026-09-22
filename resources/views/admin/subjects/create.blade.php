@extends('layouts.admin')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<h1 class="h3 mb-4">Tambah Mata Pelajaran</h1>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.subjects.store') }}">
            @include('admin.subjects._form', ['subject' => null])
        </form>
    </div>
</div>
@endsection
