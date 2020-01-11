@extends('salary.salarylayout')
@section('title')
Employees Salary| 
@endsection
@section('header')
Employees Salary
@endsection
@section('headerContent')
	<a class="btn btn-primary float-right btn-sm" href="{{ url()->previous() }}" role="button"  title="Back"><i class="fa fa-arrow-left"></i></a>
	<a class="btn btn-primary float-right btn-sm" href="{{ route('salary.create') }}" role="button"  title="Add Salary" style="margin-right: 5px;"><i class="fa fa-plus"></i></a>
@endsection

@section('empContent')
<table id="salaryTable" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%" data-page-length="10" data-callback="deleteAction">
	<thead>
		<tr>
			<th>S.no</th>
			<th>Name</th>
			<th>Email</th>
			<th>Month</th>
			<th>Total Pay</th>
			<th>Total Deduction</th>
			<th>Action</th>
		</tr>
	</thead>
</table>
@endsection
@include('employee.modals.delete')
@section('footer_script')
<script>
	
	var setOptions = {
		targets:[ 0,6 ],
		data:{
			
		}
	};
	setOptions.data.emp_id = '{{$emp_id?$emp_id:""}}';
	initDataTable('salaryTable',"{{ route('salary.list') }}",setOptions);
	
</script>
@endsection
