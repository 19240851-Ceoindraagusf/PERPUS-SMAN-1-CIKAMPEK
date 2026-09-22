@extends('layouts.admin')

@section('title', 'Edit Mata Pelajaran')

@section('content')
<h1 class="h3 mb-4">Edit Mata Pelajaran</h1>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.subjects.update', $subject) }}">
            @method('PUT')
            @include('admin.subjects._form')
        </form>
    </div>
</div>
@endsection
