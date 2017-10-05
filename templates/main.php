<div id="page-content" ng-controller="HomeController as vm">
	<div class="container-fluid block" data-ng-style="{'max-width':'5120px'}" >
	    <!-- slider parent container -->
	    <section class="content-section" data-ng-style="{'max-width':'5120px', 'margin':'0 auto'}">
	      <!-- slider container -->
			<div class="rev_slider_wrapper" style="background-color:#ccc;margin:0px auto;padding:0px;margin-top:50px;margin-bottom:80px;">
	        	<!-- angular-revolution as attribute in div -->
		        <div rev-slider ng-if="slides"
		          id="rev_slider"
		          class="rev_slider"
		          data-version="5.1.1RC"
		          slider-Type="{{slider.sliderType}}"
		          slider-Layout="{{slider.sliderLayout}}"
		          responsive-Levels="{{slider.responsiveLevels}}"
		          gridwidth="{{slider.gridwidth}}"
		          gridheight="{{slider.gridheight}}"
		          auto-Height="{{slider.autoHeight}}"
		          min-Height="{{slider.minHeight}}"
		          full-Screen-Offset-Container="{{slider.fullScreenOffsetContainer}}"
		          full-Screen-Offset="{{slider.fullScreenOffset}}"
		          delay="{{slider.delay}}"
		          disable-Progress-Bar="{{slider.disableProgressBar}}"
		          start-Delay="{{slider.startDelay}}"
		          stop-After-Loops="{{slider.stopAfterLoops}}"
		          stop-At-Slide="{{slider.stopAtSlide}}"
		          view-Port="{{slider.viewPort}}"
		          lazy-Type="{{slider.lazyType}}"
		          dotted-Overlay="{{slider.dottedOverlay}}"
		          shadow="{{slider.shadow}}"
		          spinner="{{slider.spinner}}"
		          hide-All-Caption-At-Lilmit="{{slider.hideAllCaptionAtLilmit}}"
		          hide-Caption-At-Limit="{{slider.hideCaptionAtLimit}}"
		          hide-Slider-At-Limit="{{slider.hideSliderAtLimit}}"
		          debug-Mode="{{slider.debugMode}}"
		          extensions="{{slider.extensions}}"
		          extensionssuffix="{{slider.extensions_suffix}}"
		          fallbacks="{{slider.fallbacks}}"
		          parallax="{{slider.parallax}}"
		          rev-Carousel="{{slider.carousel}}"
		          navigation="{{slider.navigation}}"
		          js-File-Location="{{slider.jsFileLocation}}"
		          visibility-Levels="{{slider.visibilityLevels}}"
		          hide-Thumbs-On-Mobile="{{slider.hideThumbsOnMobile}}"
		          slides="slides"
		          slider-Template-Url="templates/slider.tpl2.php"
		        >
		        </div>
	      	</div>
	    </section>
	</div>
	<section class="block" id="inicio" ng-include="'templates/seccion/inicio.html'"></section>
	<section class="block" id="servicios" ng-include="'templates/seccion/servicios.html'"></section>
	<section class="block mt-xxl" id="noticias" ng-include="'templates/seccion/noticias.php'" ></section>
	<!-- <section class="block mt-xxl" id="trabaja" ng-include="'templates/seccion/trabaja-con-nosotros.html'" ></section> -->
	<section class="block" id="contacto" ng-include="'templates/seccion/contacto.html'"></section>
</div><!-- PAGE CONTENT -->