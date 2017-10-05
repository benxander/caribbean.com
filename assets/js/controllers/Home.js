(function() {
  'use strict';

	angular
	    .module('caribbean')
	    .controller('HomeController', HomeController)
	    .service('HomeServices', HomeServices);
	function HomeController($scope,$routeParams,$timeout,$location,$window,HomeServices,BlogServices) {
	    var vm = this;
	    HomeServices.sCargarBanners().then(function (response) {
	      if(response.flag == 1){
	        $scope.slides = response.datos;
	      }else{
	        console.log('no data');
	      }
	    });
	    $scope.fData = {}

	    // SECCION SLIDER DE CABECERA.
	      $scope.slider = {
	        sliderType: "standard",
	        sliderLayout: "fullwidth",
	        responsiveLevels: [5120,1920, 1024, 778, 480],
	        gridwidth: [5120,1930, 1240, 778, 480],
	        gridheight: [2250, 850, 768, 960, 720],
	        autoHeight: "on",
	        minHeight: "",
	        fullScreenOffsetContainer: "",
	        fullScreenOffset: "",
	        delay: 9000,
	        disableProgressBar: "off",
	        startDelay: "",
	        stopAfterLoops: "",
	        stopAtSlide: "",
	        viewPort: {},
	        lazyType: "none",
	        dottedOverlay: "none",
	        shadow: 0,
	        spinner: "spinner2",
	        hideAllCaptionAtLilmit: 0,
	        hideCaptionAtLimit: 0,
	        hideSliderAtLimit: 0,
	        debugMode: false,
	        extensions: "",
	        extensions_suffix: "",
	        fallbacks: {
	          simplifyAll: "off",
	          disableFocusListener: true
	        },
	        parallax: {
	          type: "scroll",
	          origo: "enterpoint",
	          speed: 400,
	          levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50]
	        },
	        carousel: {},
	        navigation: {
	          keyboardNavigation: "off",
	          keyboard_direction: "horizontal",
	          mouseScrollNavigation: "off",
	          onHoverStop: "off",
	          touch: {
	            touchenabled: "on",
	            swipe_treshold: 75,
	            swipe_min_touches: 1,
	            drag_block_vertical: false,
	            swipe_direction: "horizontal"
	          },
	          tabs: {
	            style: "zeus",
	            enable: false,
	            width: 150,
	            height: 30,
	            min_width: 100,
	            wrapper_padding: 0,
	            wrapper_color: "transparent",
	            wrapper_opacity: "0",
	            tmp: '<span class="tp-tab-title">{{title}}</span>',
	            visibleAmount: 3,
	            hide_onmobile: true,
	            hide_under: 480,
	            hide_onleave: false,
	            hide_delay: 200,
	            direction: "horizontal",
	            span: true,
	            position: "inner",
	            space: 1,
	            h_align: "left",
	            v_align: "top",
	            h_offset: 30,
	            v_offset: 30
	          }
	        },
	        jsFileLocation: "",
	        visibilityLevels: [1240, 1024, 778, 480],
	        hideThumbsOnMobile: "off",
	      };
	    // SECCION BLOG
	      // $scope.verBlog = function(){
	      //   $scope.pageInicio = false;
	      //   $scope.ruta = 'templates/blog.php';
	      //   $("html, body").animate({
	      //         scrollTop: 0
	      //     }, 800, 'linear');
	      // }
	      if( $location.path() == '/' ){
	        var paramDatos = {
	          'limit': 3,
	          'sortName': 'fecha',
	          'sort' : 'DESC'
	        }
	        BlogServices.sCargarNoticiasSeccion(paramDatos).then(function (rpta) {
	          if(rpta.flag == 1){
	            vm.listaNoticiasSec = rpta.datos;
	            console.log(vm.listaNoticiasSec);

	          }else{
	            console.log('no data');
	          }
	        });
	      }
	    // SECCION CONTACTO
		    $scope.captchaValido = false;
		    window.recaptchaResponse = function(token) {
		        $scope.captchaValido = true;
		    };

		    $scope.keyRecaptcha='';
		    window.onloadCallback = function(){
		        console.log('location.path()',$location.path());
		        if( $location.path() == '/' ){
		          $timeout(function() {
		            $scope.keyRecaptcha =  '6LedKS8UAAAAAEJQu9f2HFyRN_Dlg00DjEGlSdo_';
		            grecaptcha.render('reCaptcha', {
		              'sitekey' : $scope.keyRecaptcha,
		              'callback' : recaptchaResponse,
		            });
		          },1500);
		        }
		    }

		    $scope.enviar = function(){
		        if(!$scope.captchaValido){
		          $scope.fAlert = {};
		          $scope.fAlert.type= 'danger';
		          $scope.fAlert.msg= 'Debe completar reCaptcha';
		          $scope.fAlert.strStrong = 'Error.';
		        }else{
		          $scope.fAlert = {};
		          $scope.fAlert.type= 'success';
		          $scope.fAlert.msg= 'Mensaje enviado correctamente';
		          $scope.fAlert.strStrong = 'OK.';
		          $scope.captchaValido = false;
		          grecaptcha.reset();
		          $scope.fData = {}
		        }
		        $timeout(function() {
		          $scope.fAlert = {};
		        },4000);
		    }
	}

	function HomeServices($http, $q) {
	    return({
	    	sCargarBanners: sCargarBanners,
	    });
	    function sCargarBanners(pDatos) {
	      	var datos = pDatos || {};
	      	var request = $http({
	            method : "post",
	            url :  angular.patchURLCI + "Banner/cargar_banners_web",
	            data : datos
	      	});
	      	return (request.then( handleSuccess,handleError ));
	    }
	}

})();