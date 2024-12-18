@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="main_category" class="form-label">Main Category</label>
            <input type="text" name="main_category" id="main_category" class="form-control" value="{{ $category->main_category }}" required>
        </div>
        <div class="mb-3">
            <label for="sub_category" class="form-label">Subcategory</label>
            <input type="text" name="sub_category" id="sub_category" class="form-control" value="{{ $category->sub_category }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>
@endsection
