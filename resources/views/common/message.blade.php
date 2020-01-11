@if (session('status'))
	<div class="alert alert-success" role="alert">
		{{ session('status') }}
	</div>
@endif
@if(session()->get('success'))
<div class="alert alert-success">
  {{ session()->get('success') }}  
</div>
@endif
@if ($errors->any())
  <div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		  <li>{{ $error }}</li>
		@endforeach
	</ul>
  </div>
@endif