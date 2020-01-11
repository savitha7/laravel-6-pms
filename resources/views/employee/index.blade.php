@extends('employee.emplayout')
@section('title')
Employees | 
@endsection
@section('header')
Employees
@endsection
@section('headerContent')
<a class="btn btn-primary btn-sm float-right" href="{{ route('employees.create') }}" role="button"  title="Add"><i class="fa fa-plus"></i></a>
@endsection

@section('empContent')
<table id="emplopeeTable" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%" data-page-length="10" data-callback="deleteAction">
	<thead>
		<tr>
			<th>S.no</th>
			<th>Image</th>
			<th>Name</th>
			<th>Email</th>
			<th>Designation</th>
			<th>DOJ</th>
			<th>Salary</th>
			<th>Action</th>
		</tr>
	</thead>
</table>
@endsection
@include('employee.modals.delete')
@section('footer_script')
<script>
	
	var setOptions = {
		targets:[ 1,4,7 ],
		data:{}
	};

	initDataTable('emplopeeTable',"{{ route('employees.list') }}",setOptions);
	
</script>
@endsection
