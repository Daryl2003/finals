@extends('admin.layouts.app')

@section('content')
<h1>Edit User</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control" required>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>
   <button type="submit" class="btn btn-primary">Update</button>
</form>

@endsection