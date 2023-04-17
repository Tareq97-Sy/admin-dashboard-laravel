@extends('adminlte::page')

<!DOCTYPE html>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link href="DataTables/datatables.min.css" rel="stylesheet"/>
 
<script src="DataTables/datatables.min.js" defer></script> -->


	
@section('content')
<div class="row">
        <div class="col-md-12">
                <a href="admin/create" class="btn btn-success">Create</a>
          
        </div>
    </div>
<table id="mytable" class="table table-hover text-nowrap">
<thead>
<tr>
<th>Admin name</th>
<th>Department</th>
<th>Email</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->department }}</td>
                    <td>{{ $admin->email }}</td>
					<td>
                    <div class="d-flex ">
					<a class="btn btn-primary mr-1" href="{{ route('admin.show', ['admin' => $admin->id]) }}">Info</a>
					<!-- <a class="btn btn-warning  mr-1" href="{{ route('admin.edit',$admin) }}">Edit</a> -->
					
                    <form action="{{ route('admin.destroy', $admin) }}" method="POST">
                            @csrf
                            @method('DELETE')
							<button type="submit" class="btn btn-danger ml-1" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
            </form>
                    </div>
                </td>
                  
                </tr>
            @endforeach
</tbody>
</table>
{{$admins->links()}}

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