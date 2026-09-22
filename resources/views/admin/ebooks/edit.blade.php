@extends('layouts.admin')

@section('title', 'Edit E-Book')

@section('content')
<h1 class="h3 mb-4">Edit E-Book</h1>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.ebooks.update', $ebook) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.ebooks._form')
        </form>
    </div>
</div>
@endsection
