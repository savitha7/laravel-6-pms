@extends('employee.emplayout')
@section('title')
Employee Details |
@endsection
@section('header')
Employee Details
@endsection

@section('headerContent')
<a class="btn btn-primary float-right btn-sm" href="{{ route('employees.index') }}" role="button"  title="Back"><i class="fa fa-arrow-left"></i></a>
<a class="btn btn-primary btn-sm float-right" href="{{ route('salary.create',['emp_id'=>$employee_uid]) }}" role="button"  title="Add Salary" style="margin-right: 5px;"><i class="fa fa-plus"></i></a>
@endsection

@section('empContent')
<div class="row">
    <div class="col-lg-8">
		<table class="table table-bordered">
			<tbody>
			  <tr>
				<td><strong>Name</strong></td>
				<td>{{$employee->name}}</td>
			  </tr>
			  <tr>
				<td><strong>Email</strong></td>
				<td>{{$employee->email}}</td>
			  </tr>
			  <tr>
				<td><strong>Designation</strong></td>
				<td>
				@foreach($employee->roles as $role)
					<span class="btn btn-secondary btn-sm" >{{$role->name}}</span>
				@endforeach
				</td>
			  </tr>
			  <tr>
				<td><strong>Address</strong></td>
				<td>{{$employee->address}}</td>
			  </tr>
			  <tr>
				<td><strong>DOJ</strong></td>
				<td>{{date('M d, Y', strtotime($employee->doj))}}</td>
			  </tr>
			</tbody>
		</table>
  </div>
  <div class="col-lg-4 ">
	@if($employee->photo != '' && file_exists( public_path('/assets/images/employee/'.$employee->photo)))
		<img src="{{ASSET_URL}}assets/images/employee/{{$employee->photo}}" class="img-responsive img-thumbnail pull-right" >
	@endif
  </div>
</div>
@endsection
