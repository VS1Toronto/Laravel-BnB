<!doctype html>
	<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Laravel BnB @yield('title')</title>

		<!-- Scripts -->

		<!-- Fonts -->
		<link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
		
        <script src="https://kit.fontawesome.com/e1345bac8d.js" crossorigin="anonymous"></script>

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		
		<!-- Body Background and Footer CSS -->
		<!-- -->
		<style>
			body{
				background-color: #ffffff;
			}

			* {
				margin: 0;
			}
			html, body {
				height: 100%;
			}
			.wrapper {
				min-height: 100%;
				height: auto !important;
				height: 100%;
				margin: 0 auto -50px; /* the bottom margin is the negative value of the footer's height */
			}

			.footer, .push {
				height: 50px; /* .push must be the same height as .footer */
			}

			.footer {
				position:absolute;
				width:100%;
				bottom:0;
				margin-top:30px;
				padding:10px;
				color:#fff;
				background:#B2B2B2;
			}

		</style>
		
		@yield('styles')
	</head>
	<body>
		<div id="app">
			<main>			
				<index></index>

				@yield('content')
			</main>
		</div>

		<script src="{{ asset('js/app.js') }}" defer></script>
		
		@yield('scripts')
		
	</body>
	</html>