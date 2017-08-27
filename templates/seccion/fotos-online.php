<section class="full-section dark-section parallax" id="section-28" data-stellar-background-ratio="0.1" ng-if="seccionWeb"style="background-image: url(uploads/banners/FONDO/{{seccionWeb[4].contenedor[0].imagen_bg}});">
	<div class="full-section-overlay-color"></div>
	<div class="full-section-container">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="title text-center" style="margin-bottom:15px;">
						<h3>{{seccionWeb[6].contenedor[0].titulo}}</h3>
					</div><!-- headline -->
				</div><!-- col -->
			</div><!-- row -->
		</div><!-- container -->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h5 class="text-center"><strong>{{seccionWeb[6].contenedor[0].subtitulo}}</strong></h5>
				</div><!-- col -->
			</div><!-- row -->
		</div><!-- container -->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">

					<data-owl-carousel class="owl-carousel process-slider"
						data-options="{navigation: true, pagination: false, rewindNav : true,
							responsive: {
								0:{
									items: 1
								},
								768:{
									items: 2
								},
								991:{
									items: 3
								}
							},
				            autoplay: true,loop: true
			            }"
			            >
				      	<div owl-carousel-item="" ng-repeat="item in ::items1" class="item">
							<div class="service-box style-7">
								<i class="{{::item.clase}}"></i>
								<div class="service-box-content">
									<h6><a href="">{{::item.titulo}}</a></h6>
									<p>{{::item.descripcion}}</p>
								</div><!-- service-box-content -->
							</div><!-- service-box -->
						</div><!-- item -->

				    </data-owl-carousel>



				</div><!-- col -->
			</div><!-- row -->
		</div><!-- container -->
	</div><!-- full-section-container -->
</section><!-- full-section -->