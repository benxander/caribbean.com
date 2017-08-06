(function() {
  'use strict';

  angular
    .module('caribbean')
    .controller('MainController', MainController)
    .service('rootServices', rootServices)
    .directive('hcChart', function () {
      return {
          restrict: 'E',
          template: '<div></div>',
          scope: {
              options: '='
          },
          link: function (scope, element) {
            // scope.$watch(function () {
            //   return attrs.chart;
            // }, function () {
            //     if (!attrs.chart) return;
            //     var charts = JSON.parse(attrs.chart);
            //     $(element[0]).highcharts(charts);
                Highcharts.chart(element[0], scope.options);
            // });

          }
      };
    })
    .directive('fancybox', function ($compile, $http) {
      return {
        restrict: 'A',
        controller: function($scope) {
          $scope.openFancybox = function (url) {
            $http.get(url).then(function(response) {
                if (response.status == 200) {

                    var template = angular.element(response.data);
                    var compiledTemplate = $compile(template);
                    compiledTemplate($scope);

                    $.fancybox.open({
                      content: template,
                      type: 'html',
                      maxWidth: 450,
                      maxHeight: 350,
                      fitToView: false,
                      width: '90%',
                      height: '90%',
                      padding: 0,
                      autoSize: false,
                      closeClick: false,
                      openMethod: 'dropIn',
                      openSpeed: 150,
                      closeMethod: 'dropOut',
                      closeSpeed: 150,
                      beforeShow: function () {
                        $("#main-container").addClass("bluring");
                      },
                      afterClose: function () {
                        $("#main-container").removeClass("bluring");
                      }
                    });
                }
            });
          };
        }
      };
    });

  /** @ngInject */
  function MainController($scope,$timeout, $location, $window, rootServices) {
    var vm = this;
    // console.log('$translate',$translate);
    $scope.dirWeb = angular.patchURL;
    // $scope.fSessionCI = {};

    $scope.goToUrl = function ( path ) {
      $location.path( path );
    };

    rootServices.sCargarBanners().then(function (response) {
      if(response.flag == 1){
        vm.slides = response.datos;
        $scope.slides = vm.slides;
        console.log('SLIDER ',vm.slides);
      }else{
        console.log('no data');
      }
    });
    // $timeout(function() {
    //   console.log('SLIDES ',$scope.slides);
    // }, 3000 );
    // $scope.slides = [{
    //   imagen: 'uploads/banners/SLIDER/bg-slide-1.jpg',
    //   titulo: 'Pic 1'
    // }, {
    //   imagen: 'uploads/banners/SLIDER/bg-slide-2.jpg',
    //   titulo: 'Pic 2'
    // }];

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
  function rootServices($http, $q) {
    return({
        sCargarBanners: sCargarBanners,
        // sLogoutSessionCI: sLogoutSessionCI,
        // sGetSessionCI: sGetSessionCI,
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
    // function sLogoutSessionCI(pDatos) {
    //   var datos = pDatos || {};
    //   var request = $http({
    //         method : "post",
    //         url :  angular.patchURLCI + "Acceso/logoutSessionCI",
    //         data : datos
    //   });
    //   return (request.then( handleSuccess,handleError ));
    // }
    // function sGetSessionCI(pDatos) {
    //   var datos = pDatos || {};
    //   var request = $http({
    //         method : "post",
    //         url :  angular.patchURLCI + "Acceso/getSessionCI",
    //         data : datos
    //   });
    //   return (request.then( handleSuccess,handleError ));
    // }
  }
})();
