@extends('layouts.admin')

@section('title', 'Tambah E-Book')

@section('content')
<h1 class="h3 mb-4">Tambah E-Book</h1>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.ebooks.store') }}" enctype="multipart/form-data">
            @include('admin.ebooks._form', ['ebook' => null])
        </form>
    </div>
</div>
@endsection
