@extends('salary.salarylayout')
@section('title')
Employee Salary | 
@endsection
@section('header')
Employee Salary
@endsection

@section('headerContent')
<a class="btn btn-primary float-right btn-sm" href="{{ url()->previous() }}" role="button"  title="Back"><i class="fa fa-arrow-left"></i></a>
@endsection

@section('empContent')
	<h5 class="text-center"><strong>{{date('F, Y', strtotime($salary->salary_month))}} Salary</strong></h5><hr>
<div class="row">
    <div class="col-lg-9">
		<table class="table table-bordered">   
			<tbody>
			  <tr>
				<td><strong>Nmae</strong></td>
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
				<tr>
				<td><strong>Working Days</strong></td>
				<td>{{$salary->working_days}}</td>
			  </tr>				  
			</tbody>
		</table>
  </div>
  <div class="col-lg-3 ">
	@if($employee->photo != '' && file_exists( public_path('/assets/images/employee/'.$employee->photo)))
		<img src="{{ASSET_URL}}assets/images/employee/{{$employee->photo}}" class="img-responsive img-thumbnail pull-right" >
	@endif
  </div>
</div>
<br>
<span id="dots"></span><span id="more" style="display: none;">
<div class="row">
    <div class="col-lg-12">
		<table class="table">
		<thead>
		  <tr>
			<th>Earnings</th>
			<th>Amount</th>
			<th>Deductions</th>
			<th>Amount</th>
		  </tr>
		</thead>		
			<tbody>
			  <tr>
				<td>Basic</td>
				<td>{{$salary->basic_pay}}</td>
				<td>Provident Fund</td>
				<td>{{$salary->provident_fund}}</td>
			  </tr>
			  <tr>
				<td>HRA</td>
				<td>{{$salary->hra}}</td>
				<td>Professional Tax</td>
				<td>{{$salary->professional_tax}}</td>
			  </tr>		  
			  <tr>
				<td>Medical Allowance</td>
				<td>{{$salary->medical_allowance}}</td>
				<td></td>
				<td></td>
			  </tr>
			  <tr>
				<td>Special Allowance</td>
				<td>{{$salary->special_allowance}}</td>
				<td></td>
				<td></td>
			  </tr>	
			  <tr>
				<td>Transport</td>
				<td>{{$salary->transport}}</td>
				<td></td>
				<td></td>
			  </tr>
			   <tr>
				<td>LTA</td>
				<td>{{$salary->lta}}</td>
				<td></td>
				<td></td>
			  </tr>	
				<tr>
				<td>Incentive</td>
				<td>{{$salary->incentive}}</td>
				<td></td>
				<td></td>
			  </tr>				  
			</tbody>
			<tfoot>
			  <tr>
				<th>Total Earnings</th>
				<th>{{$salary->total_pay}}</th>
				<th>Total Deductions</th>
				<th>{{$salary->total_deduction}}</th>
			  </tr>
			</tfoot>
		</table>
  </div>
</div>
</span>
<button onclick="readMorebtn()" class="btn btn-info" id="myBtn">Read more</button>
@endsection
@section('footer_script')
<script>
function readMorebtn() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more";
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less";
    moreText.style.display = "inline";
  }
}	
</script>
@endsection
