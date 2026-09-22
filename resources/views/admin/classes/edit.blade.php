@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')
<h1 class="h3 mb-4">Edit Kelas</h1>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.classes.update', $class) }}">
            @method('PUT')
            @include('admin.classes._form')
        </form>
    </div>
</div>
@endsection
