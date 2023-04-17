@extends('adminlte::page')
@section('content')
<div class="col d-flex justify-content-center"> 
<div class="card" style="width: 36rem;">
<img src="{{ Storage::url('trainees/'.$trainee->profile_picture) }}" alt="Profile Image">
 <div class="card-body">
  <h5 class="card-title">{{ $trainee->name }}</h5>
  <p class="card-text">{{ $trainee->lastname }}</p>
  <p class="card-text">{{ $trainee->email }}</p>
    <div class="col-md-8">
         
            <form action="{{ route('trainee.destroy', $trainee) }}" method="POST" class="d-inline-block" id="delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this trainee?')">Delete</button>
            </form>
            <a href="{{ route('trainee.index') }}" class="btn btn-primary">Back</a>
            </div>
  </div>
</div>


@endsection