(function() {
  'use strict';

  angular
    .module('caribbean')
    .controller('InicioController', InicioController)
    .service( 'InicioServices', InicioServices);
  function InicioController($scope, InicioServices) {
    var vm = this;
    InicioServices.sCargarSecciones().then(function (response) {
      if(response.flag == 1){
        vm.seccionWeb = response.datos;
        console.log(vm.seccionWeb );
      }else{
        console.log('no data');
      }
    });

    InicioServices.sCargarBanners().then(function (response) {
      if(response.flag == 1){
        // vm.slides = response.datos;
        vm.slides = response.datos;
        // console.log('SLIDER ',vm.slides);
      }else{
        console.log('no data');
      }
    });
    // slider settings object set to scope.
      $scope.slider = {
        sliderType: "standard",
        sliderLayout: "fullwidth",
        responsiveLevels: [1920, 1024, 778, 480],
        gridwidth: [1930, 1240, 778, 480],
        gridheight: [850, 768, 960, 720],
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
        spinner: "off",
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
  }

  function InicioServices($http, $q) {
    return({
        sCargarSecciones: sCargarSecciones,
        sCargarBanners: sCargarBanners
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
    function sCargarSecciones(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
            url :  angular.patchURLCI + "Seccion/listar_secciones_web",
            data : datos
      });
      return (request.then( handleSuccess,handleError ));
    }
  }

})();
