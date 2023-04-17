@extends('adminlte::page')
@section('content')
<div class="col d-flex justify-content-center"> 
<div class="card" style="width: 36rem;">
<img src="{{ Storage::url('instructors/'.$instructor->profile_picture) }}" alt="Profile Image">
  <div class="card-body">
  <h2 class="card-title">{{ $instructor->name }}</h2>
  <p class="card-text">{{ $instructor->department }}</p>
  <p class="card-text">{{ $instructor->email }}</p>
    <p class="card-text">{{ $instructor->bio }}</p>
    <div class="col-md-8">
            <!-- <a href="{{ route('instructor.edit', $instructor) }}" class="btn btn-primary">Edit</a> -->
            <form action="{{ route('instructor.destroy', $instructor) }}" method="POST" class="d-inline-block" id="delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this instructor?')">Delete</button>
            </form>
            <a href="{{ route('instructor.index') }}" class="btn btn-primary">Back</a>
            </div>
  </div>
</div>


            <!-- <div class="col-md-9">
                <h1>{{ $instructor->name }}</h1>
                <p class="lead">{{ $instructor->department }}</p>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h2>Contact Information</h2>
                <ul class="list-unstyled">
                    <li><strong>Email:</strong> {{ $instructor->email }}</li>
                    <li><strong>Phone:</strong> {{ $instructor->phone }}</li>
                </ul>
            </div>
            
                
            </div>
           
        </div>
        
      
    </div> -->
@endsection