@extends('layouts.admin')

@section('title', 'Tambah Kelas')

@section('content')
<h1 class="h3 mb-4">Tambah Kelas</h1>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.classes.store') }}">
            @include('admin.classes._form', ['class' => null])
        </form>
    </div>
</div>
@endsection
