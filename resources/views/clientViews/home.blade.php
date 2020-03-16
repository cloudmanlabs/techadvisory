<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta content="ie=edge" http-equiv="X-UA-Compatible">

		<title>Tech Advisory Platform</title>
		<link href="./assets/vendors/core/core.css" rel="stylesheet">
		<link href="./assets/fonts/feather-font/css/iconfont.css" rel="stylesheet">
		<link href="./assets/vendors/dropzone/dropzone.min.css" rel="stylesheet">
		<link href="./assets/css/techadvisory/style.css" rel="stylesheet">
		<link href="./assets/css/techadvisory/extra.css" rel="stylesheet">
	</head>

	<body>
		<div class="main-wrapper">
			<div class="horizontal-menu">
				<nav class="navbar top-navbar">
					<div class="container">
						<div class="navbar-content">
							<a class="navbar-brand" href="./client_home.html"><img src="./assets/images/techadvisory-logo.png" style="max-height: 37px;"></a>

							<form class="search-form">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i data-feather="search"></i>
										</div>
									</div>
									<input class="form-control" id="navbarForm" placeholder="Search here..." type="text">
								</div>
							</form>


							<ul class="navbar-nav">



								<li class="nav-item dropdown nav-profile">
									<a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="profileDropdown" role="button"><img alt="profile" src="./assets/images/user.png"></a>

									<div aria-labelledby="profileDropdown" class="dropdown-menu">
										<div class="dropdown-header d-flex flex-column align-items-center">
											<div class="info text-center">
												<p class="name font-weight-bold mb-0">Company Name</p>
											</div>
										</div>


										<div class="dropdown-body">
											<ul class="profile-nav p-0 pt-3">
												<li class="nav-item">
													<a class="nav-link" href="./login.html"><i data-feather="log-out"></i> <span>Log Out</span></a>
												</li>
											</ul>
										</div>
									</div>
								</li>
							</ul>
							<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" data-toggle="horizontal-menu-toggle" type="button"><i data-feather="menu"></i></button>
						</div>
					</div>
				</nav>


				<nav class="bottom-navbar">
					<div class="container">
						<ul class="nav page-navigation menu-client">
							<li class="nav-item active">
								<a class="nav-link" href="client_home.html">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box link-icon"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
									<span class="menu-title">Home</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book link-icon"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
									<span class="menu-title">Projects</span>
									<i class="link-arrow"></i>
								</a>
								<div class="submenu">
									<ul class="submenu-item">
										<li class="category-heading">Projects</li>
										<li class="nav-item"><a class="nav-link" href="./client_home.html#preparation_phase">Preparation Phase</a></li>
										<li class="nav-item"><a class="nav-link" href="./client_home.html#open_projects">Open Projects</a></li>
										<li class="nav-item"><a class="nav-link" href="./client_home.html#closed_projects">Closed Projects</a></li>

									</ul>
								</div>
							</li>









						</ul>
					</div>
				</nav>
			</div>


			<div class="page-wrapper">
				<div class="page-content">

					<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
						<div>
							<h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
						</div>
					</div>



					<div class="row">
						<div class="col-lg-12 grid-margin stretch-card" id="open_projects">
							<div class="card">
								<div class="card-body">
									<h3>Open Projects</h3>
									<p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
									<br>
									<br>

									<div class="card" style="margin-bottom: 30px;">
										<div class="card-body">
											<div style="float: left; max-width: 40%;">
												<h4>Global Transport Management</h4>
												<h6>Solution type</h6>
											</div>
											<div style="float: right; text-align: right; width: 15%;">
												<a class="btn btn-primary btn-lg btn-icon-text" href="client_project_home.html">View <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
											</div>
											<div style="float: right; width: 35%; margin-right: 10%;">
												Current status
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
												</div>
											</div>
										</div>
									</div>


									<div class="card" style="margin-bottom: 30px;">
										<div class="card-body">
											<div style="float: left; max-width: 40%;">
												<h4>Future of leadership</h4>
												<h6>Solution type</h6>
											</div>
											<div style="float: right; text-align: right; width: 15%;">
												<a class="btn btn-primary btn-lg btn-icon-text" href="client_project_home.html">View <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
											</div>
											<div style="float: right; width: 35%; margin-right: 10%;">
												Current status
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
												</div>
											</div>
										</div>
									</div>


									<div class="card" style="margin-bottom: 30px;">
										<div class="card-body">
											<div style="float: left; max-width: 40%;">
												<h4>Another project title</h4>
												<h6>Solution type</h6>
											</div>
											<div style="float: right; text-align: right; width: 15%;">
												<a class="btn btn-primary btn-lg btn-icon-text" href="client_project_home.html">View <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
											</div>
											<div style="float: right; width: 35%; margin-right: 10%;">
												Current status
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">90%</div>
												</div>
											</div>
										</div>
									</div>


									<div class="card" style="margin-bottom: 30px;">
										<div class="card-body">
											<div style="float: left; max-width: 40%;">
												<h4>Last of latest projects title</h4>
												<h6>Solution type</h6>
											</div>
											<div style="float: right; text-align: right; width: 15%;">
												<a class="btn btn-primary btn-lg btn-icon-text" href="client_project_home.html">View <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
											</div>
											<div style="float: right; width: 35%; margin-right: 10%;">
												Current status
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
												</div>
											</div>
										</div>
									</div>




								</div>
							</div>
						</div>
					</div>
					<div class="row" id="preparation_phase">
						<div class="col-lg-12 grid-margin stretch-card">
							<div class="card">
								<div class="card-body">
									<h3>Preparation phase</h3>
									<p class="welcome_text extra-top-15px">In order to start using the Tech Advisory Platform, you'll need to follow some steps to complete your profile and set up your first project. Please check below the timeline and click "Let's start" when you are ready.</p>
									<br>
									<br>

									<div class="card" style="margin-bottom: 30px;">
										<div class="card-body">
											<div style="float: left; max-width: 40%;">
												<h4>Redistribution of processes at Nestlé</h4>
												<h6>Solution type</h6>
											</div>
											<div style="float: right; text-align: right; width: 17%;">
												<a class="btn btn-primary btn-lg btn-icon-text" href="client_new_project_set_up.html">Complete <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
											</div>
											<!--<div style="float: right; width: 35%; margin-right: 5%; margin-left: 5%;">
												Current status
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5%</div>
												</div>
											</div>-->
										</div>
									</div>






								</div>
							</div>
						</div>
					</div>
				</div>


				<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
					<p class="text-muted text-center text-md-left" style="text-align: center; margin: 0 auto;">Copyright © 2020 Tech Advisory Platform.</p>
				</footer>
			</div>
		</div>
		<script src="./assets/vendors/core/core.js">
	</script>
		<script src="./assets/vendors/chartjs/Chart.min.js">
	</script>
		<script src="./assets/vendors/jquery.flot/jquery.flot.js">
	</script>
		<script src="./assets/vendors/jquery.flot/jquery.flot.resize.js">
	</script>
		<script src="./assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js">
	</script>
		<script src="./assets/vendors/apexcharts/apexcharts.min.js">
	</script>
		<script src="./assets/vendors/progressbar.js/progressbar.min.js">
	</script>
		<script src="./assets/vendors/feather-icons/feather.min.js">
	</script>
		<script src="./assets/js/template.js">
	</script>
		<script src="./assets/js/dashboard.js">
	</script>
		<script src="./assets/js/datepicker.js">
	</script>
	</body>
</html>
