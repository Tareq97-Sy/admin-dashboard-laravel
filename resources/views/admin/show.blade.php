@extends('adminlte::page')

@section('content')

<div class="col d-flex justify-content-center"> 
<div class="card" style="width: 36rem;">
<img src="{{ Storage::url('admins/'.$admin->profile_picture) }}" alt="Profile Image">
  <div class="card-body">
  <h2 class="card-title">{{ $admin->name }}</h2>
  <p class="card-text">{{ $admin->department }}</p>
  <p class="card-text">{{ $admin->email }}</p>
    <div class="col-md-8">
            <!-- <a href="{{ route('admin.edit', $admin) }}" class="btn btn-warning  mr-1">Edit</a> -->
            <form action="{{ route('admin.destroy', $admin) }}" method="POST" class="d-inline-block" id="delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
            </form>
            <a href="{{ route('admin.index') }}" class="btn  btn-default  mr-10">Back</a>
            </div>
  </div>
</div>

@endsection