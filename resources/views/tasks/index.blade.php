@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang ="en">
<head>
<meta charset="UTF-8">

<!-- boostrap css CDN -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- boostrap js CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<title>Todo List App</title>
</head>
<body>
<div class="container">
<div class="col-md-offset-2 col-md-8">
<div class="row">
<h1>To do List</h1>
</div>


<!-- display success message -->
@if(Session::has('success'))
<div class="alert alert-success">
	<strong>Success : </strong>{{Session::get('success')}}
</div>
@endif

<!-- Filter the list of users by priority -->
<div class="row">
Order by: 
 <a href="/tasks">Order by Latest to Earliest</a>
</div>


Priority: 
<a href="/tasks?priority=low">Low</a> | 
<a href="/tasks?priority=medium">Medium</a> | 
<a href="/tasks?priority=high">High</a> | 
<a href="/tasks?priority=urgent">Urgent</a>

<!-- display error message -->
@if(count($errors)>0)
<div class="alert alert-danger">
<strong>
	Error:
	<ul>
		@foreach($errors->all() as $error)
		<li>
			{{$error}}
		</li>
		@endforeach
	</ul>
</strong>
	
</div>




@endif
<div class="row" style='margin-top:10px; margin-bottom:10px;'>
	<form action="{{route('tasks.store')}}" method='POST'>
	<div class="col-md-9">
	{{csrf_field()}}
	<h5>Name:</h5> <input type="text" name="newTaskName" class='form-control'>
	</div>

	<div class="col-md-9">
	<h5>Description:</h5>
	<input type="text" name="newTaskDescription" class='form-control'>
	</div>

		<div class="col-md-9" style='margin-top:10px; margin-bottom:10px;'>Priority:
</div>
	
	<div class="col-md-9">

<input type="radio" name="newPriority" value="medium" checked> Medium
</div>
<div class="col-md-9">
<input type="radio" name="newPriority" value="high"> High
</div>
<div class="col-md-9">
<input type="radio" name="newPriority" value="low"> Low
</div>
<div class="col-md-9">
<input type="radio" name="newPriority" value="urgent"> Urgent
</div>


	<div class="col-md-3">
	<input type="submit" class='btn btn-primary btn-block' value="Add Task">
	</div>
	</form>
</div>
<!-- display stored tasks -->
@if (count($storedTasks)>0)
<table class="table">
	<thead>
	<th>
		Task #
	</th>
	<th>
		Name
	</th>
	<th>
		Description
	</th>
	<th>
		Priority
	</th>
	<th>
		Edit
	</th>
	<th>
		Delete
	</th>
	</thead>

	<tbody>
		@foreach ($storedTasks as $storedTask)
		<tr>
			

		<td>
			{{$storedTask->id}}
		</td>
		<td>
			{{$storedTask->name}}
		</td>
		<td>
			{{$storedTask->description}}
		</td>
		<td>
			{{$storedTask->priority}}
		</td>
		<td>
			<a href="{{route('tasks.edit', ['tasks'=>$storedTask->id])}}" class="btn btn-default" value="Edit">Edit</a>
		</td>
		<td>
			<form action="{{route('tasks.destroy',['tasks'=>$storedTask->id])}}" method='POST'>
			{{csrf_field()}}
			<input type="hidden" name='_method' value='DELETE'>
				<input type="submit" class="btn btn-danger" value="Delete">
			</form>
		</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endif

<div class="row text-center">{{$storedTasks->links()}}</div>
</div>
</div>	
</body>
</html>
@endsection
