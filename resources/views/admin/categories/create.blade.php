@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Add New Category</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="is_subcategory" class="form-label">Is this a Subcategory?</label>
            <select name="is_subcategory" id="is_subcategory" class="form-control" required>
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>

        <div class="mb-3" id="parent_category_container" style="display: none;">
            <label for="parent_category" class="form-label">Select Parent Category</label>
            <select name="parent_category" id="parent_category" class="form-control">
                <option value="">-- Select Parent Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Create Category</button>
    </form>
</div>

<script>
    // Toggle the display of the parent category selection when subcategory is selected
    document.getElementById('is_subcategory').addEventListener('change', function() {
        var parentCategoryContainer = document.getElementById('parent_category_container');
        if (this.value == '1') {
            parentCategoryContainer.style.display = 'block';
        } else {
            parentCategoryContainer.style.display = 'none';
        }
    });
</script>
@endsection
