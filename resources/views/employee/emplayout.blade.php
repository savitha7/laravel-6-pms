@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">@yield('header')@yield('headerContent')				
				</div>

                <div class="card-body">
                    @include('common/message')
                    @yield('empContent')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
