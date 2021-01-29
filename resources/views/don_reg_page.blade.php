@extends('layouts.admin')

@section('content')


	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-10">
	            <div class="card">
	                <div class="card-header">{{ __('Register Donation') }}</div>

	                <div class="card-body">
	                    <form method="POST" action="/don_reg">
	                        @csrf

	                        <div class="form-group row">
	                            <label for="" class="col-md-4 col-form-label text-md-right">{{ __('Well Wisher') }}</label>

	                            <div class="col-md-6">
	                                <input id="" type="text" class="form-control" name="well_wisher" value="{{ old('staff_firstname') }}" required autocomplete="email" autofocus>
	                            </div>
	                        </div>

	                        <div class="form-group row">
	                            <label for="" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

	                            <div class="col-md-6">
	                                <input id="" type="number" class="form-control" name="amount" required >

	                            </div>
	                        </div>
	                        <div class="form-group row mb-0">
	                            <div class="col-md-8 offset-md-4">
	                                <button type="submit" class="btn btn-primary">
	                                    {{ __('Register') }}
	                                </button>
	                                <a href="/donation" type="button" class="btn btn-warning">
	                                    {{ __('Cancel') }}
	                                </a>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection
