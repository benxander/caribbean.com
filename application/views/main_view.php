<!DOCTYPE html>
<html ng-app="caribbean">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<base href="<?=base_url()?>">
	<title>Caribbean Photo Studio</title>
	<!-- FAVICON AND APPLE TOUCH -->
	<link rel="shortcut icon" href="favicon.png">
	<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-180x180.png">
	<meta name="msapplication-TileImage" content="mstile.png">
	<meta name="msapplication-TileColor" content="#8a1a4a">
	<meta name="theme-color" content="#8a1a4a">

	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>bower_components/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>bower_components/font-awesome/css/font-awesome.css">

	<!-- FONTS -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7C;Open+Sans:300,300i,400,400i,700,700i%7C;Playfair+Display:400,400i,900,900i">
	<!-- HALCYON ICONS -->
	<link rel="stylesheet" href="assets/fonts/halcyon-icons/css/halcyon-icons.min.css">
	<link rel="stylesheet" href="assets/fonts/halcyon-school-icons/css/halcyon-school-icons.min.css">
	<link rel="stylesheet" href="assets/fonts/halcyon-interface-icons/css/halcyon-interface-icons.min.css">
	<link rel="stylesheet" href="assets/fonts/halcyon-office-icons/css/halcyon-office-icons.min.css">
	<!-- FANCYBOX -->
	<link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.css">

	<!-- REVOLUTION SLIDER -->
	<link rel="stylesheet" href="assets/plugins/revolutionslider/css/settings.css">
	<link rel="stylesheet" href="assets/plugins/revolutionslider/css/layers.css">
	<link rel="stylesheet" href="assets/plugins/revolutionslider/css/navigation.css">

	<!-- OWL Carousel -->
	<link rel="stylesheet" href="assets/plugins/owl-carousel/owl.carousel.css">

	<!-- COUNTERS -->
	<link rel="stylesheet" href="assets/plugins/counters/odometer-theme-default.css">

	<!-- YOUTUBE PLAYER -->
	<link rel="stylesheet" href="assets/plugins/ytplayer/css/jquery.mb.ytplayer.min.css">

	<!-- ANIMATIONS -->
	<link rel="stylesheet" href="assets/plugins/animations/animate.min.css">

	<!-- CUSTOM & PAGES STYLE -->
	<link rel="stylesheet" href="assets/css/custom.css">
	<link rel="stylesheet" href="assets/css/pages-style.css">


</head>
<body class="sticky-header header-white">
	<div id="main-container">
		<!-- HEADER -->
		<header id="header">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-3">
						<!-- LOGO -->
						<div id="logo">
							<a href="index.html">
								<img src="assets/images/logo-dark.png" alt="">
							</a>
						</div><!-- LOGO -->
					</div><!-- col -->
					<div class="col-sm-9">
						<!-- MENU -->
						<nav>

							<a id="mobile-menu-button" class="waves" href="#"><i class="halcyon-icon-menu"></i></a>

							<ul class="menu clearfix" id="menu">
								<li class="active">
									<a href="index.html">Inicio</a>
								</li>
								<li class="dropdown">
									<a href="#">Servicios</a>
									<ul>
										<li class="dropdown">
											<a class="waves" href="#">Servicios 1</a>
											<ul>
												<li><a class="waves" href="">ABC</a></li>
												<li><a class="waves" href="">XYZ</a></li>
											</ul>
										</li>
										<li class="dropdown">
											<a class="waves" href="#">Servicios 2</a>
											<ul>
												<li><a class="waves" href="">ABC</a></li>
												<li><a class="waves" href="">XYZ</a></li>
											</ul>
										</li>
										<li class="dropdown">
											<a class="waves" href="#">Servicios 3</a>
											<ul>
												<li><a class="waves" href="">ABC</a></li>
												<li><a class="waves" href="">XYZ</a></li>
											</ul>
										</li>
									</ul>
								</li>
								<li class="">
									<a href="#">Noticias</a>
								</li>
								<li class="">
									<a href="#">Trabaja con nosotros</a>
								</li>
								<li class="">
									<a href="#">Contacto</a>
								</li>
								<li class="search">

									<a href="#search-form-container"><i class="halcyon-icon-search-1"></i></a>

									<div id="search-form-container">

										<form id="search-form" action="#">
											<input id="search" type="search" name="search" placeholder="Enter keywords...">
											<input id="search-submit" type="submit" value="">
										</form>

									</div><!-- search-form-container -->

								</li>
								<li class="login">

									<a class="btn btn-default-2 waves" href="#login-form-container">Sign In</a>

									<div id="login-form-container">

										<h4>Login Form</h4>

										<form class="login-form" name="login" novalidate method="post" action="#">
											<fieldset>

												<p>
													<input class="col-xs-12" id="email" type="email" placeholder="" required>
													<label for="email">E-mail address</label>
												</p>

												<p>
													<input class="col-xs-12" id="password" type="password" placeholder="" required>
													<label for="password">Password</label>
												</p>

												<div class="checkbox">
													<label>
														<input type="checkbox"> Remember me
													</label>
												</div>

												<button type="submit" class="btn btn-default-1 waves">Log in</button>

											</fieldset>
										</form>

										<a href="#">Don't have an account?</a> <br class="visible-xs-block">
										<a href="#">Forgotten password?</a>

									</div><!-- login-form-container -->

								</li>
							</ul>

						</nav>
					</div>
				</div>
			</div>
		</header>
		<!-- PAGE CONTENT -->
		<div id="page-content">
			<div class="rev_slider_wrapper">
                <div class="rev_slider" data-version="5.0">
                    <ul>
                        <li data-transition="fade" data-thumb="images/index/revolution-slider/bg-slide-1.jpg">

                            <img src="images/index/revolution-slider/bg-slide-1.jpg" alt="">

							<div class="tp-caption title-big-white"
								 data-x="center"
								 data-y="center"
								 data-voffset="-100"
								 data-start="1200"
								 data-speed="300"
								 data-transform_in="o:0;y:100;s:500;e:Power2.easeInOut;"
								 data-transform_out="o:0;y:-100;s:500;e:Power2.easeInOut;">
								 Create
							</div>

							<div class="tp-caption title-big-white"
								 data-x="center"
								 data-y="center"
								 data-start="1250"
								 data-speed="300"
								 data-transform_in="o:0;y:100;s:500;e:Power2.easeInOut;"
								 data-transform_out="o:0;y:-100;s:500;e:Power2.easeInOut;">
								 space with
							</div>

							<div class="tp-caption title-big-white"
								 data-x="center"
								 data-y="center"
								 data-voffset="110"
								 data-start="1300"
								 data-speed="300"
								 data-transform_in="o:0;y:100;s:500;e:Power2.easeInOut;"
								 data-transform_out="o:0;y:-100;s:500;e:Power2.easeInOut;">
								 Halcyon
							</div>

							<div class="tp-caption subtitle-white text-center"
								 data-x="center"
								 data-y="center"
								 data-voffset="240"
								 data-start="1400"
								 data-speed="300"
								 data-transform_in="o:0;y:100;s:500;e:Power2.easeInOut;"
								 data-transform_out="o:0;y:-100;s:500;e:Power2.easeInOut;">
								 Hundred unique sections to choose from <br>
								 +30 Different Layouts, with free updates
							</div>

						</li>
						<li data-transition="fade" data-thumb="images/index/revolution-slider/bg-slide-2.jpg">

                            <img src="images/index/revolution-slider/bg-slide-2.jpg" alt="">

							<div class="tp-caption title-white-bold"
								 data-x="center"
								 data-y="center"
								 data-voffset="-90"
								 data-start="1200"
								 data-speed="300"
								 data-transform_in="o:0;y:100;s:500;e:Power2.easeInOut;"
								 data-transform_out="o:0;y:-100;s:500;e:Power2.easeInOut;">
								 Build your space
							</div>

							<div class="tp-caption title-white-bold"
								 data-x="center"
								 data-y="center"
								 data-start="1250"
								 data-speed="300"
								 data-transform_in="o:0;y:100;s:500;e:Power2.easeInOut;"
								 data-transform_out="o:0;y:-100;s:500;e:Power2.easeInOut;">
								 with Halcyon
							</div>

							<div class="tp-caption"
								 data-x="center"
								 data-y="center"
								 data-voffset="90"
								 data-start="1300"
								 data-speed="300"
								 data-transform_in="o:0;y:100;s:500;e:Power2.easeInOut;"
								 data-transform_out="o:0;y:-100;s:500;e:Power2.easeInOut;">
								 <a class="btn btn-default-1 waves" href="#">Purchase <i class="fa fa-angle-right"></i></a>
							</div>

						</li>
					</ul>
				</div><!-- rev_slider_wrapper -->
			</div><!-- rev_slider -->

			<div class="container">
				<div class="row">
					<div class="col-md-6">

						<h3>A huge number of demos to choose from</h3>

						<h5><strong>All you need is Halcyon , modern and simple. <br class="visible-sm-block">
						Equipted with all the elements you need.</strong></h5>

						<br>

						<p>Feugiat consequat eu sed eros. Cras suscipit eu est sed imperdiet. Curabitur ultrices dolor magna,
						at vene natis lacus rutrum nec. Quisque elit velit, lacinia sit amet tellus at, auctor suscipit
						metus. Duis congue nibh at tortor ornare, sed commo do ipsum mattis. Phasellus lacinia sed purus eget
						rhoncus.</p>

						<br>

						<p><a class="btn btn-default-1 waves" href="#">Discover</a></p>

					</div><!-- col -->
					<div class="col-md-6">

						<div class="row">
							<div class="col-sm-6">

								<p><img class="wow fadeInRight" src="images/index/image-20.jpg" alt=""></p>

							</div><!-- col -->
							<div class="col-sm-6">

								<p><img class="wow fadeInRight" src="images/index/image-21.jpg" alt="" data-wow-delay="0.1s"></p>

							</div><!-- col -->
						</div><!-- row -->

					</div><!-- col -->
				</div><!-- row -->
			</div><!-- container -->

			<section class="full-section parallax" id="section-26" data-stellar-background-ratio="0.1">
				<div class="full-section-container">

					<div class="container-fluid">
						<div class="row">
							<div class="col-md-offset-5 col-sm-offset-1 col-md-7 col-sm-10">

								<h2>After years of constant research we came up with Halcyon. A new Experience.</h2>

								<p>designed and developed by <strong>milothemes</strong>. <br>
								Sold <strong>exclusivley</strong> on Envato Marketplace</p>

								<br>

								<a class="btn btn-default-1 waves" href="#">Purchase now <i class="fa fa-angle-right"></i></a>

							</div><!-- col -->
						</div><!-- row -->
					</div><!-- container-fluid -->

				</div><!-- full-section-container -->
			</section><!-- full-section -->

			<section class="full-section parallax" id="section-27" data-stellar-background-ratio="0.1">
				<div class="full-section-container">

					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-offset-1 col-lg-4 col-md-6 col-sm-10">

								<h2>A new way of doing business has come to town. Try iy now!</h2>

								<p>Feugiat consequat eu sed eros. Cras suscipit eu est sed imperdiet. Curabitur ultrices
								dolor magna, at vene natis lacus rutrum nec. Quisque elit velit, lacinia sit amet tellus at,
								auctor suscipit metus. Duis congue nibh at tortor ornare, sed com mo do ipsum mattis.
								Phasellus lacinia sed purus eget rhoncus. Feugiat consequat eu sed eros. Cras suscipit eu est
								sed imperdiet. Curabitur ultrices dolor magna, at vene natis lacus rutrum nec. Quisque elit
								velit, lacinia sit amet tellus at, auctor suscipit metus.</p>

							</div><!-- col -->
						</div><!-- row -->
					</div><!-- container-fluid -->

				</div><!-- full-section-container -->
			</section><!-- full-section -->

			<div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="title">

							<h3>Practical Solutions</h3>

						</div><!-- headline -->

                    </div><!-- col -->
                </div><!-- row -->
            </div><!-- container -->

			<div class="container">
                <div class="row">
                    <div class="col-md-4">

                        <h5><strong>Modern and simple. Equipted with all the elements you need.</strong></h5>

						<br>

						<p>Aenean luctus mi mollis quam feugiat consequat eu sed eros. Cras suscipit eu est sed imperdiet.
						Curabitur ultrices dolor magna, at vene natis lacus rutrum nec. Quisque elit velit, lacinia sit amet
						tellus at, auctor sus cipit metus. Duis congue nibh at tortor ornare, sed commo do ipsum mattis.
						Phasellus lacinia sed purus eget rhoncus. Mauris ut tortor efficitur.</p>

						<br>

						<p><a class="btn btn-default-1 waves" href="#">Discover</a></p>

						<br class="hidden-lg hidden-md">

                    </div><!-- col -->
					<div class="col-md-8">

                        <div class="row">
							<div class="col-sm-6">

								<div class="service-box style-4 wow fadeIn">

									<i class="halcyon-icon-worldwide-1"></i>

									<h6><a href="single-service.html">World recognicion</a></h6>

									<div class="service-box-content">

										<p>Lorem ipsum dolor sit amet, consec tetur adipiscing elit. Pellentesque vitae dui.</p>

									</div><!-- service-box-content -->

								</div><!-- service-box -->

							</div><!-- col -->
							<div class="col-sm-6">

								<div class="service-box style-4 wow fadeIn" data-wow-delay="0.1s">

									<i class="halcyon-icon-network"></i>

									<h6><a href="single-service.html">Test our products</a></h6>

									<div class="service-box-content">

										<p>Etiam turpis tortor, finibus quis urna eu, venenatis dapibus leo. Etiam sit amet
										fringilla.</p>

									</div><!-- service-box-content -->

								</div><!-- service-box -->

							</div><!-- col -->
						</div><!-- row -->

						<div class="row">
							<div class="col-sm-6">

								<div class="service-box style-4 wow fadeIn">

									<i class="halcyon-icon-database-3"></i>

									<h6><a href="single-service.html">Profit's on the way</a></h6>

									<div class="service-box-content">

										<p>Aliquam pretium diam a elit dignissim, sit amet sodales neque tristique. Duis non.</p>

									</div><!-- service-box-content -->

								</div><!-- service-box -->

							</div><!-- col -->
							<div class="col-sm-6">

								<div class="service-box style-4 wow fadeIn" data-wow-delay="0.1s">

									<i class="halcyon-icon-paper-plane-1"></i>

									<h6><a href="single-service.html">Contact us</a></h6>

									<div class="service-box-content">

										<p>Praesent et laoreet tortor. Ut molestie ac dolor ut maximus. Vestibulum vestibulum
										enim.</p>

									</div><!-- service-box-content -->

								</div><!-- service-box -->

							</div><!-- col -->
						</div><!-- row -->

                    </div><!-- col -->
                </div><!-- row -->
            </div><!-- container -->

			<section class="full-section dark-section parallax" id="section-28" data-stellar-background-ratio="0.1">

				<div class="full-section-overlay-color"></div>

				<div class="full-section-container">

					<div class="container">
						<div class="row">
							<div class="col-sm-12">

								<div class="title text-center" style="margin-bottom:15px;">

									<h3>Work process</h3>

								</div><!-- headline -->

							</div><!-- col -->
						</div><!-- row -->
					</div><!-- container -->

					<div class="container">
						<div class="row">
							<div class="col-sm-12">

								<h5 class="text-center"><strong>Modern and simple. Equipted with all the elements you need.</strong></h5>

							</div><!-- col -->
						</div><!-- row -->
					</div><!-- container -->

					<div class="container">
						<div class="row">
							<div class="col-sm-12">

								<div class="owl-carousel process-slider">
									<div class="item">

										<div class="service-box style-7">

											<i class="halcyon-icon-eyeglasses"></i>

											<div class="service-box-content">

												<h6><a href="single-service.html">Responsive</a></h6>

												<p>Aenean luctus mi mollis quam feugiat consequat eu sed eros. Cras suscipit
												eu est sed imperdiet luctus.</p>

											</div><!-- service-box-content -->

										</div><!-- service-box -->

									</div><!-- item -->
									<div class="item">

										<div class="service-box style-7">

											<i class="halcyon-icon-settings-4"></i>

											<div class="service-box-content">

												<h6><a href="single-service.html">More gear power</a></h6>

												<p>Luctus mi mollis quam feugiat conseq uat eu sed eros. Cras suscipit eu est
												sed imperdiet. Aenean mdiet.</p>

											</div><!-- service-box-content -->

										</div><!-- service-box -->

									</div><!-- item -->
									<div class="item">

										<div class="service-box style-7">

											<i class="halcyon-icon-database-3"></i>

											<div class="service-box-content">

												<h6><a href="single-service.html">Money well spend</a></h6>

												<p>Enean luctus mi mollis quam feugiat consequat eu sed eros. Cras suscipit
												eu est sed imperdiet. Aenean luctus.</p>

											</div><!-- service-box-content -->

										</div><!-- service-box -->

									</div><!-- item -->
									<div class="item">

										<div class="service-box style-7">

											<i class="halcyon-icon-notebook-4"></i>

											<div class="service-box-content">

												<h6><a href="single-service.html">Well documented</a></h6>

												<p>Cras tristique felis sed nulla ullamcorper laoreet. Donec sed porta augue,
												ornare maximus nisi est.</p>

											</div><!-- service-box-content -->

										</div><!-- service-box -->

									</div><!-- item -->
									<div class="item">

										<div class="service-box style-7">

											<i class="halcyon-icon-star"></i>

											<div class="service-box-content">

												<h6><a href="single-service.html">Fast response</a></h6>

												<p>Vivamus mollis nisi purus, id euismod magna finibus ut. Nullam bibendum
												neque vitae lectus dapibus.</p>

											</div><!-- service-box-content -->

										</div><!-- service-box -->

									</div><!-- item -->
								</div><!-- process-slider -->

							</div><!-- col -->
						</div><!-- row -->
					</div><!-- container -->

				</div><!-- full-section-container -->
			</section><!-- full-section -->
		</div><!-- PAGE CONTENT -->
		<!-- FOOTER -->
		<footer id="footer-container">

			<div id="footer" class="default-color">

				<div class="container">
					<div class="row">
						<div class="col-sm-12">

							<div class="widget widget-social">

								<div class="social-media text-center">

									<a class="pinterest" href="#"><i class="fa fa-pinterest"></i></a>
									<a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a>
									<a class="instagram" href="#"><i class="fa fa-instagram"></i></a>
									<a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
									<a class="twitter" href="#"><i class="fa fa-twitter"></i></a>

								</div><!-- social-media -->

							</div><!-- widget-social -->

						</div><!-- col -->
					</div><!-- row -->
				</div><!-- container -->

			</div><!-- footer -->

			<div id="footer-bottom">

				<div class="container">
					<div class="row">
						<div class="col-sm-12">

							<div class="widget widget-text">

								<div class="text-center">

									<img src="assets/images/footer-logo.png" alt="">

									<p><small>2017 &copy; All rights reserved</small></p>

								</div>

							</div><!-- widget-text -->

						</div><!-- col -->
					</div><!-- row -->
				</div><!-- container -->

			</div><!-- footer-bottom -->
		</footer><!-- FOOTER CONTAINER -->
	</div><!-- MAIN CONTAINER -->
	<!-- SCROLL UP -->
	<a id="scroll-up" class="waves"><i class="fa fa-angle-up"></i></a>
	<!-- THEME OPTIONS -->
	<div id="theme-options"></div>
	<script src="<?= base_url() ?>bower_components/jquery/dist/jquery.js"></script>
	<script src="<?= base_url() ?>bower_components/bootstrap/dist/js/bootstrap.js"></script>

	<script src="<?=base_url()?>bower_components/angular/angular.js"></script>
	<script src="<?=base_url()?>bower_components/angular-route/angular-route.js"></script>
	<script src="<?=base_url()?>bower_components/angular-cookies/angular-cookies.js"></script>
	<script src="<?=base_url()?>bower_components/ng-facebook/ngFacebook.js"></script>
	<script src="<?=base_url()?>bower_components/oclazyload/dist/ocLazyLoad.js"></script>

	<!-- VIEWPORT -->
	<script src="assets/plugins/viewport/jquery.viewport.js"></script>

	<!-- MENU -->
	<script src="assets/plugins/menu/hoverIntent.js"></script>
	<script src="assets/plugins/menu/superfish.js"></script>

	<!-- FANCYBOX -->
	<script src="assets/plugins/fancybox/jquery.fancybox.pack.js"></script>

	<!-- REVOLUTION SLIDER  -->
	<script src="assets/plugins/revolutionslider/js/jquery.themepunch.tools.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/jquery.themepunch.revolution.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/extensions/revolution.extension.actions.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/extensions/revolution.extension.carousel.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/extensions/revolution.extension.kenburn.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/extensions/revolution.extension.layeranimation.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/extensions/revolution.extension.migration.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/extensions/revolution.extension.navigation.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/extensions/revolution.extension.parallax.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/extensions/revolution.extension.slideanims.min.js"></script>
	<script src="assets/plugins/revolutionslider/js/extensions/revolution.extension.video.min.js"></script>

	<!-- OWL Carousel -->
	<script src="assets/plugins/owl-carousel/owl.carousel.min.js"></script>

	<!-- PARALLAX -->
	<script src="assets/plugins/parallax/jquery.stellar.min.js"></script>

	<!-- ISOTOPE -->
	<script src="assets/plugins/isotope/imagesloaded.pkgd.min.js"></script>
	<script src="assets/plugins/isotope/isotope.pkgd.min.js"></script>

	<!-- PLACEHOLDER -->
	<script src="assets/plugins/placeholders/jquery.placeholder.min.js"></script>

	<!-- CONTACT FORM VALIDATE & SUBMIT -->
	<script src="assets/plugins/validate/jquery.validate.min.js"></script>
	<script src="assets/plugins/submit/jquery.form.min.js"></script>

	<!-- GOOGLE MAPS -->
	<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyD3E-0gEeAoazgA2D7W0DAmPv1pYA5hPJ4"></script>
	<script src="assets/plugins/googlemaps/gmap3.min.js"></script>

	<!-- CHARTS -->
	<script src="assets/plugins/charts/jquery.easypiechart.min.js"></script>

	<!-- COUNTER -->
	<script src="assets/plugins/counters/jquerysimplecounter.js"></script>
	<script src="assets/plugins/counters/odometer.min.js"></script>

	<!-- STATISTICS -->
	<script src="assets/plugins/statistics/chart.min.js"></script>

	<!-- INSTAFEED -->
	<script src="assets/plugins/instafeed/instafeed.min.js"></script>

	<!-- TWITTER -->
	<script src="assets/plugins/twitter/twitterfetcher.min.js"></script>

	<!-- YOUTUBE PLAYER -->
	<script src="assets/plugins/ytplayer/jquery.mb.ytplayer.min.js"></script>

	<!-- COUNTDOWN -->
	<script src="assets/plugins/countdown/jquery.countdown.min.js"></script>

	<!-- ANIMATIONS -->
	<script src="assets/plugins/animations/wow.min.js"></script>

	<!-- CUSTOM JS -->
	<script src="assets/js/custom.js"></script>

	<script src="<?=base_url()?>assets/js/app.js"></script>
	<script>
	  // window.fbAsyncInit = function() {
	  //   FB.init({
	  //     appId      : '197123207485024',
	  //     xfbml      : true,
	  //     version    : 'v2.9'
	  //   });
	  //   FB.AppEvents.logPageView();
	  // };

	  // (function(d, s, id){
	  //    var js, fjs = d.getElementsByTagName(s)[0];
	  //    if (d.getElementById(id)) {return;}
	  //    js = d.createElement(s); js.id = id;
	  //    js.src = "//connect.facebook.net/en_US/sdk.js";
	  //    fjs.parentNode.insertBefore(js, fjs);
	  //  }(document, 'script', 'facebook-jssdk'));
	</script>

</body>
</html>