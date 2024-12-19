@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Manage Categories</h1>
    <div class="card mb-4">
        
                <a href="{{ route('categories.create') }}" style="background-color:grey;" class="btn btn-primary mb-3">Add New Category</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Main Category</th>
                            <th>Subcategory</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    @if(is_null($category->parent_id))
                                        {{ $category->name }} <!-- Main Category -->
                                    @else
                                        {{ $category->parent->name }} <!-- Parent Category for Subcategory -->
                                    @endif
                                </td>
                                <td>
                                    @if(!is_null($category->parent_id))
                                        {{ $category->name }} <!-- Subcategory Name -->
                                    @else
                                        N/A <!-- No Subcategory for Main Category -->
                                    @endif
                                </td>
                                <td>
                                    <!-- Delete Button Form -->
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        
    </div>
</div>
@endsection
