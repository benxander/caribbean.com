(function() {
  'use strict';

  angular
    .module('caribbean')
    .controller('MainController', MainController)
    .service('rootServices', rootServices)
    .directive('fancybox', function(){
      return {
        restrict: 'A',

        link: function(scope, element, attrs){
          $(element).fancybox({
            type        :'inline',
            scrolling   : 'yes',
            maxWidth    : 1000,
            maxHeight   : 600,
            fitToView   : true,
            width       : '80%',
            height      : '90%',
            autoSize    : false,
            closeClick  : true,
            openEffect  : 'none',
            closeEffect : 'none'
          });
        }
      }
    })
    .directive("owlCarousel", function() {
      return {
        restrict: 'E',
        transclude: false,
        link: function (scope) {
          scope.initCarousel = function(element) {
            // provide any default options you want
            var defaultOptions = {
            };
            var customOptions = scope.$eval($(element).attr('data-options'));
            // combine the two options objects
            for(var key in customOptions) {
              defaultOptions[key] = customOptions[key];
            }
            // init carousel
            $(element).owlCarousel(defaultOptions);
          };
        }
      };
    })
    .directive('owlCarouselItem', [function() {
      return {
        restrict: 'A',
        transclude: false,
        link: function(scope, element) {
          // wait for the last item in the ng-repeat then call init
          if(scope.$last) {
            scope.initCarousel(element.parent());
          }
        }
      };
    }]);

  /** @ngInject */
  function MainController($scope,$timeout, $location, $window, rootServices, BlogServices,$routeParams) {
    var vm = this;
    // console.log('$translate',$translate);
    $scope.dirWeb = angular.patchURL;
    $scope.pageInicio = true;

    // $scope.fSessionCI = {};
    // $scope.items1 = [
    //   {
    //     'titulo': 'Responsive',
    //     'descripcion' : 'Aenean luctus mi mollis quam feugiat consequat eu sed eros. Cras suscipit eu est sed imperdiet luctus.',
    //     'clase' : 'halcyon-icon-eyeglasses'
    //   },
    //   {
    //     'titulo': 'Seleccione sus fotos',
    //     'descripcion' : 'Luctus mi mollis quam feugiat conseq uat eu sed eros. Cras suscipit eu est sed imperdiet. Aenean mdiet.',
    //     'clase' : 'halcyon-icon-photo-camera'
    //   },
    //   {
    //     'titulo': 'Pagos con Paypal y Tarjeta',
    //     'descripcion' : 'Luctus mi mollis quam feugiat conseq uat eu sed eros. Cras suscipit eu est sed imperdiet. Aenean mdiet.',
    //     'clase' : 'halcyon-icon-id-card-4'
    //   },
    //   {
    //     'titulo': 'Otro item',
    //     'descripcion' : 'Luctus mi mollis quam feugiat conseq uat eu sed eros. Cras suscipit eu est sed imperdiet. Aenean mdiet.',
    //     'clase' : 'halcyon-icon-id-card-2'
    //   }
    // ];

    $scope.goToUrl = function ( path ) {
      $location.path( path );
    };
    $scope.scrollTo = function(id) {
      var delay = 0;
       console.log('home');
      if($location.path( '/' )){

        $timeout(function() {
          if(id == 'inicio'){
            $("html, body").animate({
                scrollTop: 0
            }, 800, 'linear');
          }else{
            var offset = $("body").data("offset");
            $("html, body").animate({
                scrollTop: $('#'+id).offset().top - offset
            }, 800, 'linear');
            console.log('offset',$('#'+id).offset().top);
          }

        },delay);

        // $location.path( '/' );
        // delay = 200;
        // $scope.pageInicio = true;
      }else{
       console.log('blog');

      }
      return false;
    };

    rootServices.sCargarDatosWeb().then(function (response) {
      if(response.flag == 1){
        $scope.dataWeb = response.datos;
      }else{
        console.log('no data');
      }
    });
    rootServices.sCargarSecciones().then(function (response) {
      if(response.flag == 1){
        $scope.seccionWeb = response.datos;
      }else{
        console.log('no data');
      }
    });
    rootServices.sListarRedesWeb().then(function (rpta) {
      if(rpta.flag == 1){
        $scope.dataRedes = rpta.datos;
      }
    });
    // SECCION BLOG
        // $scope.verBlog = function(){
        //   $scope.pageInicio = false;
        //   $scope.ruta = 'templates/blog.php';
        //   $("html, body").animate({
        //         scrollTop: 0
        //     }, 800, 'linear');
        // }
        // if( $location.path() == '/' ){
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
        // }
    /*rootServices.sCargarBanners().then(function (response) {
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
      }*/

  }
  function rootServices($http, $q) {
    return({
        // sCargarBanners: sCargarBanners,
        sCargarDatosWeb: sCargarDatosWeb,
        sCargarSecciones: sCargarSecciones,
        sListarRedesWeb: sListarRedesWeb,
    });
    /*function sCargarBanners(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Banner/cargar_banners_web",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }*/
    function sCargarDatosWeb(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Config/listar_configuracion",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sCargarSecciones(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_secciones_web",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
    function sListarRedesWeb(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Config/listar_redes_web",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }
})();
