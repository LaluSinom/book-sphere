@extends('layouts.app')

@section('title', 'Edit Ebook')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Ebook</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Ebooks</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit Ebook</h2>

                <div class="card">
                    <form action="{{ route('ebooks.update', $ebook->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Edit Ebook Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    name="title" value="{{ old('title', $ebook->title) }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Author</label>
                                <input type="text"
                                    class="form-control @error('author') is-invalid @enderror"
                                    name="author" value="{{ old('author', $ebook->author) }}">
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Publisher</label>
                                <input type="text"
                                    class="form-control @error('publisher') is-invalid @enderror"
                                    name="publisher" value="{{ old('publisher', $ebook->publisher) }}">
                                @error('publisher')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Year</label>
                                <input type="text"
                                    class="form-control @error('year') is-invalid @enderror"
                                    name="year" value="{{ old('year', $ebook->year) }}">
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control select2 @error('category_id') is-invalid @enderror" name="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if (old('category_id', $ebook->category_id) == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $ebook->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Thumbnail</label>
                                <input type="file"
                                    class="form-control @error('tumbnail') is-invalid @enderror"
                                    name="tumbnail">
                                @if ($ebook->tumbnail)
                                    <small>Current Thumbnail:</small>
                                    <img src="{{ asset('storage/' . $ebook->tumbnail) }}" alt="Thumbnail" width="100">
                                @endif
                                @error('tumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>File</label>
                                <input type="file"
                                    class="form-control @error('file') is-invalid @enderror"
                                    name="file">
                                @if ($ebook->file)
                                    <small>Current File:</small>
                                    <a href="{{ asset('storage/' . $ebook->file) }}" target="_blank">Download</a>
                                @endif
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush