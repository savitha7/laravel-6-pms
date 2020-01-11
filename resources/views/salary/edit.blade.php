@extends('salary.salarylayout')
@section('title')
Add Employee Salary |
@endsection
@section('header')
Add Employee Salary
@endsection
@section('headerContent')
	<a class="btn btn-primary float-right btn-sm" href="{{ url()->previous() }}" role="button"  title="Back"><i class="fa fa-arrow-left"></i></a>
@endsection

@section('empContent')
	<form method="POST" action="{{ route('salary.update', $salary_uid) }}" >
		@csrf
		@method('PUT')
		<div class="row">
		<div class="col-md-6">
		<div class="form-group row">
			<label for="employee" class="col-md-4 col-form-label text-md-right">{{ __('Employee') }} <span>*</span></label>

			<div class="col-md-6">
				<select class="form-control @error('employee_id') is-invalid @enderror" id="employee" name="employee_id" required>
				  @foreach($employees as $key => $employee)
				  <option value="{{$employee->id}}" {{$employee->id == $salary->employee_id?'selected':''}}>{{$employee->name}} ({{$employee->email}})</option>
				  @endforeach
				</select>
				@error('employee_id')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>

		<div class="form-group row">
			<label for="salaryMonth" class="col-md-4 col-form-label text-md-right">{{ __('Salary Month') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="salaryMonth" type="month" class="form-control @error('salary_month') is-invalid @enderror" name="salary_month" required value="{{date('Y-m', strtotime($salary->salary_month))}}">
				@error('salary_month')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>

		<div class="form-group row">
			<label for="workingDays" class="col-md-4 col-form-label text-md-right">{{ __('Working Days') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="workingDays" type="number" class="form-control @error('working_days') is-invalid @enderror" name="working_days" required value="{{$salary->working_days}}">
				@error('working_days')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="basicPay" class="col-md-4 col-form-label text-md-right">{{ __('Basic Pay') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="basicPay" type="number" class="form-control @error('basic_pay') is-invalid @enderror" name="basic_pay" required value="{{$salary->basic_pay}}">
				@error('basic_pay')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="hra" class="col-md-4 col-form-label text-md-right">{{ __('HRA') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="hra" type="number" class="form-control @error('hra') is-invalid @enderror" name="hra" required value="{{$salary->hra}}">
				@error('hra')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="medicalAllowance" class="col-md-4 col-form-label text-md-right">{{ __('Medical Allowance') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="medicalAllowance" type="number" class="form-control @error('medical_allowance') is-invalid @enderror" name="medical_allowance" required value="{{$salary->medical_allowance}}">
				@error('medical_allowance')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="specialAllowance" class="col-md-4 col-form-label text-md-right">{{ __('Special Allowance') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="specialAllowance" type="number" class="form-control @error('special_allowance') is-invalid @enderror" name="special_allowance" required value="{{$salary->special_allowance}}">
				@error('special_allowance')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="transport" class="col-md-4 col-form-label text-md-right">{{ __('Transport') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="transport" type="number" class="form-control @error('transport') is-invalid @enderror" name="transport" required value="{{$salary->transport}}">
				@error('transport')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="lta" class="col-md-4 col-form-label text-md-right">{{ __('LTA') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="lta" type="number" class="form-control @error('lta') is-invalid @enderror" name="lta" required value="{{$salary->lta}}">
				@error('lta')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="incentive" class="col-md-4 col-form-label text-md-right">{{ __('Incentive') }}</label>

			<div class="col-md-6">
				<input id="incentive" type="number" class="form-control @error('incentive') is-invalid @enderror" name="incentive" value="{{$salary->incentive}}">
				@error('incentive')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>

		</div>
		<div class="col-md-6">
		<h5><strong>Deductions</strong></h5><hr>
		<div class="form-group row">
			<label for="providentFund" class="col-md-4 col-form-label text-md-right">{{ __('Provident Fund') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="providentFund" type="number" class="form-control @error('provident_fund') is-invalid @enderror" name="provident_fund" required value="{{$salary->provident_fund}}">
				@error('provident_fund')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="professionalTax" class="col-md-4 col-form-label text-md-right">{{ __('Professional Tax') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="professionalTax" type="number" class="form-control @error('professional_tax') is-invalid @enderror" name="professional_tax" required value="{{$salary->professional_tax}}">
				@error('professional_tax')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>

		</div>
		</div>

		<div class="form-group row pull-right">
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary">
					{{ __('Submit') }}
				</button>
			</div>
		</div>
	</form>
@endsection
