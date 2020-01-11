@extends('employee.emplayout')
@section('title')
Edit Employee |
@endsection
@section('header')
    Edit Employee
@endsection
@section('headerContent')
<a class="btn btn-primary float-right btn-sm" href="{{ route('employees.index') }}" role="button" title="Back"><i class="fa fa-arrow-left"></i></a>
@endsection

@section('empContent')
<form action="{{ route('employees.update', $employee_uid) }}" method="post" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="form-group row">
			<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $employee->name }}" required autocomplete="name" autofocus>

				@error('name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>

		<div class="form-group row">
			<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $employee->email }}" required autocomplete="email">

				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>

		<div class="form-group row">
			<label for="designation" class="col-md-4 col-form-label text-md-right">{{ __('Designation') }} <span>*</span></label>

			<div class="col-md-6">
				<select multiple class="form-control @error('roles') is-invalid @enderror" id="designation" name="roles[]" required>
				  @foreach($roles as $key => $role)
				   <option value="{{$role['id']}}" {{(($role['status'])?'selected':'')}} >{{$role['name']}}</option>
				  @endforeach
				</select>
				@error('roles')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>

		<div class="form-group row">
			<label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

			<div class="col-md-6">
				<input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{$employee->address}}" autocomplete="address">
			</div>
		</div>
		<div class="form-group row">
			<label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

			<div class="col-md-4">
			    <input type="file" class="form-control-file" id="photo" name="photo">

				@error('photo')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="col-md-4">
				@if($employee->photo != '' && file_exists( public_path('/assets/images/employee/'.$employee->photo)))
					<img src="{{ASSET_URL}}assets/images/employee/{{$employee->photo}}" class="img-responsive thumbnail" width="100">
				@endif
			</div>
		</div>
		<div class="form-group row">
			<label for="doj" class="col-md-4 col-form-label text-md-right">{{ __('DOJ') }} <span>*</span></label>

			<div class="col-md-6">
				<input id="doj" type="date" class="form-control @error('doj') is-invalid @enderror" name="doj" value="{{$employee->doj}}" required autocomplete="date">
			</div>
		</div>

		<div class="form-group row mb-0">
			<div class="col-md-6 offset-md-4">
				<button type="submit" class="btn btn-primary">
					{{ __('Update') }}
				</button>
			</div>
		</div>
	</form>
@endsection
