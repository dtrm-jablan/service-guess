@extends('layouts/main')

@section('pageSubtitle')
	Create a New Test
@endsection

@section('content')
	<form id="create-test" class="form">
		<div id="test-settings">
			<div class="row">
				<div id="test-to-run" class="col-md-12 test-group">
					<h4>Choose Tests To Run</h4>

					@foreach($testSteps as $_id => $_step)
						<div class="form-group">
							<div class="col-md-4">
								@if(!empty($_step))
									<div class="checkbox">
										<label>
											<input id="ttr-{{ $_id }}" name="ttr-{{ $_id }}" type="checkbox">
											<span class="test-step-name">{{ $_id }}</span> - {{ $_step['label'] }}
										</label>
									</div>
								@endif
							</div>
						</div>
					@endforeach

				</div>
			</div>

			<div class="row">
				<div id="test-settings" class="col-md-6 test-group">
					<h4>Test Settings</h4>
					<div class="form-group">
						<div class="col-md-6">
							<div class="checkbox">
								<label>
									<input id="set-as-reference-data" name="set-as-reference-data" type="checkbox">
									Set as reference data
								</label>
							</div>
						</div>
					</div>
				</div>

				<div id="test-emails" class="col-md-6 test-group">
					<h4>Email Test Results</h4>
					<div class="col-md-12">
						<div class="radio">
							<label>
								<input type="radio" name="te-email-option" id="te-email-option" value="0" checked>
								Do not send an email
							</label>
						</div>
					</div>

					<div class="col-md-12">
						<div class="radio">
							<label>
								<input type="radio" name="te-email-option" id="te-email-option" value="1">
								Send an email to <strong>test@determine.com</strong> in case of error
							</label>
						</div>
					</div>

					<div class="col-md-12">
						<div class="radio">
							<label>
								<input type="radio" name="te-email-option" id="te-email-option" value="2">
								Always send an email to <strong>test@determine.com</strong>
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div id="test-params" class="col-md-6 test-group">
					<h4>Runtime Parameters</h4>
					<table class="table table-condensed table-striped table-bordered">
						<thead>
							<th>Parameter</th>
							<th>Value</th>
						</thead>
						<tbody>
							<tr>
								<td>CUSTID</td>
								<td>{{ $custid }}</td>
							</tr>
							<tr>
								<td>Root URL</td>
								<td><a href="//{{ $appconf['rooturl'] }}" target="_blank">{{ $appconf['rooturl'] }}</a></td>
							</tr>
							<tr>
								<td>Root Path</td>
								<td>{{ $appconf['rootpath'] }}</td>
							</tr>
							<tr>
								<td>Main Database</td>
								<td>{{ $MainDB['dbname'] }}</td>
							</tr>
							<tr>
								<td>Test Database</td>
								<td>{{ $MainDB['dbname'] }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
@endsection

@section('after-scripts')
	<script>
	jQuery(function($) {
		$('#ttr-all').on('click', function(e) {
			if ($(this).prop('checked')) {
				$('input[id^="ttr-"]').not('#ttr-all').prop('disabled', true);
				$('input[id^="ttr-"]').not('#ttr-all').closest('div.checkbox').addClass('disabled');
			} else {
				$('input[id^="ttr-"]').not('#ttr-all').prop('disabled', false);
				$('input[id^="ttr-"]').not('#ttr-all').closest('div.checkbox').removeClass('disabled');
			}
		});

	});
	</script>
@endsection
