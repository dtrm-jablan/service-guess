<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">
	<title>Determine - GUESS</title>
	<link href='//fonts.googleapis.com/css?family=Open+Sans|Montserrat|Lato' rel='stylesheet' type='text/css'>

	@section('page-theme')
		<link href="/static/bootswatch-3.3.6/paper.min.css" rel="stylesheet">
	@show

	<link href="/static/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/guess.css" rel="stylesheet">

	<!--[if lt IE 9]>
	<script src="//oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
	<script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->

	<script src="/static/jquery-2.2.4/jquery.min.js"></script>

	@stack('head-links')

	@stack('head-scripts')
</head>
<body class="@yield('body-class')">

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php?batchpsw={{ request('batchpsw') }}">{{ config('guess.display-brand') }}</a>
			<div class="page-subtitle">{{ isset($pageSubtitle) ? $pageSubtitle : null }}</div>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				{{--<li class="active"><a href="#">Home</a></li>--}}
				{{--<li><a href="#about">About</a></li>--}}
				{{--<li><a href="#contact">Contact</a></li>--}}
				{{--<li class="dropdown">--}}
				{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown--}}
				{{--<span class="caret"></span></a>--}}
				{{--<ul class="dropdown-menu">--}}
				{{--<li><a href="#">Action</a></li>--}}
				{{--<li><a href="#">Another action</a></li>--}}
				{{--<li><a href="#">Something else here</a></li>--}}
				{{--<li role="separator" class="divider"></li>--}}
				{{--<li class="dropdown-header">Nav header</li>--}}
				{{--<li><a href="#">Separated link</a></li>--}}
				{{--<li><a href="#">One more separated link</a></li>--}}
				{{--</ul>--}}
				{{--</li>--}}
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>

<!-- Begin page content -->
<div class="container-fluid page-content">
	@yield('content')
</div>

<footer class="footer footer-inverse">
	<div class="container-fluid">
		<div class="social-links pull-right">
			<ul class="list-inline">
				<li>
					<a target="_blank"
					   href="https://twitter.com/determine/"><i class="fa fa-twitter-square fa-2x"></i></a>
				</li>
				<li>
					<a target="_blank"
					   href="https://www.linkedin.com/company/determine/"><i class="fa fa-linkedin-square fa-2x"></i></a>
				</li>
				<li>
					<a target="_blank"
					   href="https://facebook.com/determineInc/"><i class="fa fa fa-facebook-square fa-2x"></i></a>
				</li>
				<li>
					<a target="_blank"
					   href="https://plus.google.com/+determineInc"><i class="fa fa fa-google-plus-square fa-2x"></i></a>
				</li>
			</ul>
		</div>
		<div class="clearfix"></div>
		<p>
            <span class="pull-left hidden-xs">{!! config( 'guess.display-name' ) !!}
				<small style="margin-left: 5px;font-size: 9px;">({!! config('guess.display-version') !!})
                </small></span> <span class="pull-right">{!! config('guess.display-copyright') !!}</span>
		</p>
	</div>
</footer>

@stack('before-scripts')

<script src="static/bootstrap-3.3.6/js/bootstrap.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js"></script>

@stack('after-scripts')

</body>
</html>
