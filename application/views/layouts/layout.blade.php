
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<title>Haji</title>

	<!-- General CSS Files -->
	<link rel="stylesheet" href="{{ base_url('assets/modules/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ base_url('assets/modules/fontawesome/css/all.min.css') }}">

	<!-- CSS Libraries -->
	@yield('css-export')


	
	<!-- Template CSS -->
	<link rel="stylesheet" href="{{ base_url('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ base_url('assets/css/components.css') }}">

	@yield('css-inline')
	<style>
		.action-no-wrap {
			width: 1%;
			white-space: nowrap;
		}
		
	</style>

</head>

<body class="{{ $bodyClass ?? "" }}">
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<div class="navbar-bg"></div>
			<nav class="navbar navbar-expand-lg main-navbar">
				<form class="form-inline mr-auto">
					<ul class="navbar-nav mr-3">
						<li><a href="{{ base_url('#') }}" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
						<li><a href="{{ base_url('#') }}" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
					</ul>

				</form>
			{{-- 	<ul class="navbar-nav navbar-right">

				</li>
				<li class="dropdown"><a href="{{ base_url('#') }}" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
					<img alt="image" src="{{ base_url('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
					<div class="d-sm-none d-lg-inline-block">Hi, Ujang Maman</div></a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="dropdown-title">Logged in 5 min ago</div>
						<a href="{{ base_url('features-profile.html') }}" class="dropdown-item has-icon">
							<i class="far fa-user"></i> Profile
						</a>
						<a href="{{ base_url('features-activities.html') }}" class="dropdown-item has-icon">
							<i class="fas fa-bolt"></i> Activities
						</a>
						<a href="{{ base_url('features-settings.html') }}" class="dropdown-item has-icon">
							<i class="fas fa-cog"></i> Settings
						</a>
						<div class="dropdown-divider"></div>
						<a href="{{ base_url('#') }}" class="dropdown-item has-icon text-danger">
							<i class="fas fa-sign-out-alt"></i> Logout
						</a>
					</div>
				</li>
			</ul> --}}
		</nav>
		@include('layouts.sidebar')

		<!-- Main Content -->
		<div class="main-content">
			@yield('content')
		</div>
		<footer class="main-footer">
			<div class="footer-left">{{-- 
				Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="{{ base_url('https://nauval.in/') }}">Muhamad Nauval Azhar</a>
			--}}</div>
			<div class="footer-right">

			</div>
		</footer>
	</div>
</div>

<!-- General JS Scripts -->
<script src="{{ base_url('assets/modules/jquery.min.js') }}"></script>
<script src="{{ base_url('assets/modules/popper.js') }}"></script>
<script src="{{ base_url('assets/modules/tooltip.js') }}"></script>
<script src="{{ base_url('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ base_url('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ base_url('assets/modules/moment.min.js') }}"></script>
<script src="{{ base_url('assets/axios.min.js') }}"></script>
<script src="{{ base_url('assets/sweetalert2.all.min.js') }}"></script>
<script src="{{ base_url('assets/js/stisla.js') }}"></script>


@yield('js-export')

<!-- Page Specific JS File -->
@yield('js-inline')

<!-- Template JS File -->
<script src="{{ base_url('assets/js/scripts.js') }}"></script>
<script src="{{ base_url('assets/js/custom.js') }}"></script>

<script>
	
	function toggleModal(modal, state) {
		if (state == $('body').hasClass('modal-open')) {
			throw new Error('Modal is already ' + (state ? 'shown' : 'hidden') + '!');
		}

		var d = $.Deferred();

		modal.one(state ? 'shown.bs.modal' : 'hidden.bs.modal', d.resolve)
		.modal(state ? 'show' : 'hide');
		return d.promise();
	}

</script>

</body>
</html>