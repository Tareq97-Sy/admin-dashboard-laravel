@extends('adminlte::page')

<!DOCTYPE html>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link href="DataTables/datatables.min.css" rel="stylesheet"/>
 
<script src="DataTables/datatables.min.js" defer></script> -->


	
@section('content')
<div class="row">
        <div class="col-md-12">
                <a href="instructor/create" class="btn btn-success">Create</a>
          
        </div>
    </div>
<table id="mytable" class="table table-hover text-nowrap">
<thead>
<tr>
<th>Instructor name</th>
<th>Department</th>
<th>Email</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach($instructors as $instructor)
                <tr>
                    <td>{{ $instructor->name }}</td>
                    <td>{{ $instructor->department }}</td>
                    <td>{{ $instructor->email }}</td>
					<td>
                    <div class="d-flex ">
					<a class="btn btn-primary mr-1" href="{{ route('instructor.show', ['instructor' => $instructor->id]) }}">Info</a>
					<form action="{{ route('instructor.destroy', $instructor) }}" method="POST">
                            @csrf
                            @method('DELETE')
							<button type="submit" class="btn btn-danger ml-1" onclick="return confirm('Are you sure you want to delete this instructor?')">Delete</button>
            </form>
                    </div>
                </td>
                  
                </tr>
            @endforeach
</tbody>
</table>
{{$instructors->links()}}

        </div>
    </div>
@endsection

<!-- <script>
 
$(document).ready( function () {
    $('#mytable').DataTable({
		processing: true,
		serverSide:true,
		
		ajax:{
			url: "{{'pagination-instructor'}}",
		
		},
	 columns: [
            {data:'name'},
			      {data:'department'},
			      {data:'email'},
			      {data:'phone'},
			 ],
		
	})	
	});
</script> -->