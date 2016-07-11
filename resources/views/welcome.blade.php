@extends('layouts/main')

@section('content')
	<h1>GUESS</h1>

	@if(!empty($indices))
		<div>{{ print_r($indices, true) }}</div>
	@endif
@endsection
